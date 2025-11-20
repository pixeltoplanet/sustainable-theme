<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Sustainability Optimizer Class
 * 
 * Comprehensive WordPress optimization system designed to reduce environmental
 * impact while maintaining optimal performance.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class SustainabilityOptimizer
{
  private $settings;

  public function __construct()
  {
    // Load settings immediately
    $this->load_settings();
    
    // Also reload on after_setup_theme to ensure fresh settings
    add_action('after_setup_theme', [$this, 'load_settings'], 1);
    
    // Run optimizations that need to happen before WordPress registers actions
    add_action('after_setup_theme', [$this, 'early_optimizations'], 5);
    
    // Run main optimizations on init
    add_action('init', [$this, 'init_optimizations'], 10);
    
    // Frontend optimizations
    add_action('wp_enqueue_scripts', [$this, 'frontend_optimizations'], 100);
    
    // Admin optimizations
    add_action('admin_init', [$this, 'admin_optimizations']);
  }
  

  /**
   * Early optimizations that need to run before WordPress registers actions
   */
  public function early_optimizations(): void
  {
    global $pagenow;
    
    // Don't apply optimizations on site editor - it needs all its scripts/styles
    if ($pagenow === 'site-editor.php') {
      return;
    }
    
    // Reload settings to ensure we have the latest
    $this->load_settings();
    // Disable emojis early (before WordPress registers them)
    if (!empty($this->settings['disable_emojis'])) {
      $this->disable_emojis();
    }

    // Remove jQuery migrate early (before scripts are registered)
    if (!empty($this->settings['remove_jquery_migrate'])) {
      add_action('wp_default_scripts', [$this, 'remove_jquery_migrate'], 100);
    }

    // Disable heartbeat early (but NOT on site editor - it needs heartbeat)
    if (!empty($this->settings['disable_heartbeat'])) {
      add_action('wp_enqueue_scripts', [$this, 'disable_heartbeat'], 1);
      add_action('admin_enqueue_scripts', [$this, 'disable_heartbeat_safely'], 1);
      add_action('login_enqueue_scripts', [$this, 'disable_heartbeat'], 1);
    }
  }

  /**
   * Load settings (called on init to ensure they're fresh)
   */
  public function load_settings(): void
  {
    $this->settings = get_option('sustainable_theme_settings', []);
  }

  /**
   * Initialize core optimizations
   */
  public function init_optimizations(): void
  {
    global $pagenow;
    
    // Don't apply optimizations on site editor - it needs all its scripts/styles
    if ($pagenow === 'site-editor.php') {
      return;
    }
    // Remove REST API output links
    if (!empty($this->settings['remove_rest_output'])) {
      remove_action('wp_head', 'rest_output_link_wp_head', 10);
      remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
      remove_action('wp_head', 'wp_oembed_add_discovery_links');
    }

    // Disable XML-RPC
    if (!empty($this->settings['disable_xmlrpc'])) {
      add_filter('xmlrpc_enabled', '__return_false');
      add_filter('wp_headers', [$this, 'remove_xmlrpc_header']);
      add_filter('bloginfo_url', [$this, 'remove_xmlrpc_pingback_url'], 10, 2);
    }

    // Disable self pingbacks
    if (!empty($this->settings['disable_self_pingbacks'])) {
      add_filter('pre_ping', [$this, 'disable_self_pingbacks'], 10, 3);
    }

    // Remove header metadata (RSD, WLW manifest, etc.)
    if (!empty($this->settings['remove_header_metadata'])) {
      remove_action('wp_head', 'rsd_link');
      remove_action('wp_head', 'wlwmanifest_link');
      remove_action('wp_head', 'wp_generator');
      remove_action('wp_head', 'wp_shortlink_wp_head');
      remove_action('template_redirect', 'wp_shortlink_header', 11);
    }

    // Remove shortlinks (if not already removed by remove_header_metadata)
    if (!empty($this->settings['remove_shortlinks']) && empty($this->settings['remove_header_metadata'])) {
      remove_action('wp_head', 'wp_shortlink_wp_head');
      remove_action('template_redirect', 'wp_shortlink_header', 11);
    }

    // Reduce heartbeat frequency
    if (!empty($this->settings['reduce_heartbeat_frequency'])) {
      add_filter('heartbeat_settings', [$this, 'reduce_heartbeat_frequency']);
    }

    // Limit post revisions
    if (!empty($this->settings['limit_post_revisions'])) {
      add_filter('wp_revisions_to_keep', [$this, 'limit_post_revisions'], 10, 2);
    }

    // Remove query strings from static resources
    if (!empty($this->settings['remove_query_strings'])) {
      add_filter('script_loader_src', [$this, 'remove_query_strings'], 15, 1);
      add_filter('style_loader_src', [$this, 'remove_query_strings'], 15, 1);
      add_filter('script_loader_tag', [$this, 'remove_query_strings_from_tag'], 10, 3);
      add_filter('style_loader_tag', [$this, 'remove_query_strings_from_tag'], 10, 3);
    }

    // Disable comments system-wide
    if (!empty($this->settings['disable_comments'])) {
      $this->disable_comments();
    }

    // Remove WordPress version
    if (!empty($this->settings['remove_wp_version'])) {
      remove_action('wp_head', 'wp_generator');
      add_filter('the_generator', '__return_empty_string');
    }


    // Remove capital_P_dangit
    if (!empty($this->settings['remove_capital_p_dangit'])) {
      remove_filter('the_title', 'capital_P_dangit', 11);
      remove_filter('the_content', 'capital_P_dangit', 11);
      remove_filter('comment_text', 'capital_P_dangit', 31);
    }

    // Disable automatic updates
    if (!empty($this->settings['disable_automatic_updates'])) {
      $this->disable_automatic_updates();
    }


    // Disable RSS feeds
    if (!empty($this->settings['disable_rss_feed'])) {
      $this->disable_rss_feeds();
    }

    // Remove embeds
    if (!empty($this->settings['remove_embeds'])) {
      $this->remove_embeds();
    }
  }

  /**
   * Frontend-specific optimizations
   */
  public function frontend_optimizations(): void
  {
    global $pagenow;
    
    // Don't apply optimizations on site editor - it needs all its scripts/styles
    if ($pagenow === 'site-editor.php') {
      return;
    }

    // Remove DNS prefetch (works on both frontend and admin)
    if (!empty($this->settings['remove_dns_prefetch'])) {
      remove_action('wp_head', 'wp_resource_hints', 2);
    }

    if (is_admin()) {
      return;
    }

    // Dequeue non-sustainable scripts/styles
    if (!empty($this->settings['dequeue_non_sustainable'])) {
      $this->dequeue_non_sustainable();
    }

    // Disable Dashicons on frontend
    if (!empty($this->settings['disable_dashicons_frontend'])) {
      wp_dequeue_style('dashicons');
      wp_deregister_style('dashicons');
    }

    // Disable Gravatar
    if (!empty($this->settings['disable_gravatar'])) {
      add_filter('avatar_defaults', [$this, 'remove_gravatar']);
      add_filter('get_avatar', [$this, 'replace_gravatar'], 1, 5);
    }
  }

  /**
   * Admin-specific optimizations
   */
  public function admin_optimizations(): void
  {
    global $pagenow;
    
    // Don't apply optimizations on site editor - it needs all its scripts/styles
    if ($pagenow === 'site-editor.php') {
      return;
    }
    
    // Reserved for future admin-specific optimizations
  }

  /**
   * Disable emojis
   */
  private function disable_emojis(): void
  {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', [$this, 'disable_emojis_tinymce']);
    add_filter('wp_resource_hints', [$this, 'disable_emojis_dns_prefetch'], 10, 2);
  }

  /**
   * Remove emoji support from TinyMCE
   */
  public function disable_emojis_tinymce($plugins): array
  {
    if (is_array($plugins)) {
      return array_diff($plugins, ['wpemoji']);
    }
    return [];
  }

  /**
   * Remove emoji DNS prefetch
   */
  public function disable_emojis_dns_prefetch($urls, $relation_type): array
  {
    if ('dns-prefetch' === $relation_type) {
      $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
      foreach ($urls as $key => $url) {
        if (strpos($url, $emoji_svg_url) !== false) {
          unset($urls[$key]);
        }
      }
    }
    return $urls;
  }

  /**
   * Remove XML-RPC header
   */
  public function remove_xmlrpc_header($headers): array
  {
    unset($headers['X-Pingback']);
    return $headers;
  }

  /**
   * Remove XML-RPC pingback URL
   */
  public function remove_xmlrpc_pingback_url($output, $show): string
  {
    if ('pingback_url' === $show) {
      $output = '';
    }
    return $output;
  }

  /**
   * Disable self pingbacks
   */
  public function disable_self_pingbacks($links, $post, $already_pinged): array
  {
    $home = get_option('home');
    foreach ($links as $l => $link) {
      if (0 === strpos($link, $home)) {
        unset($links[$l]);
      }
    }
    return $links;
  }

  /**
   * Remove jQuery migrate
   */
  public function remove_jquery_migrate($scripts): void
  {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
      $script = $scripts->registered['jquery'];
      if ($script->deps) {
        $script->deps = array_diff($script->deps, ['jquery-migrate']);
      }
    }
    $scripts->remove('jquery-migrate');
  }

  /**
   * Disable heartbeat
   */
  public function disable_heartbeat(): void
  {
    wp_deregister_script('heartbeat');
  }

  /**
   * Disable heartbeat safely (excludes site editor)
   */
  public function disable_heartbeat_safely(): void
  {
    global $pagenow;
    // Don't disable heartbeat on site editor - it needs it to function
    if ($pagenow === 'site-editor.php') {
      return;
    }
    wp_deregister_script('heartbeat');
  }

  /**
   * Reduce heartbeat frequency
   */
  public function reduce_heartbeat_frequency($settings): array
  {
    $settings['interval'] = 120; // Default is 15-60 seconds, we set to 2 minutes
    return $settings;
  }

  /**
   * Limit post revisions
   */
  public function limit_post_revisions($num, $post): int
  {
    $limit = (int) $this->settings['limit_post_revisions'];
    return $limit > 0 ? $limit : $num;
  }

  /**
   * Remove query strings from script/style tags
   */
  public function remove_query_strings_from_tag($tag, $handle, $src): string
  {
    if (strpos($tag, '?ver=') !== false) {
      $tag = preg_replace('/\?ver=[^"\']+/', '', $tag);
    }
    return $tag;
  }

  /**
   * Remove query strings from static resources (selective)
   */
  public function remove_query_strings($src): string
  {
    // Don't remove query strings from certain file types that may need them
    $excluded_extensions = [
      '.woff',
      '.woff2',
      '.ttf',
      '.eot',
      '.otf', // Font files
      '.pdf',
      '.doc',
      '.docx',
      '.zip',
      '.rar',   // Document files
      '.mp4',
      '.webm',
      '.ogg',
      '.mp3',
      '.wav',   // Media files
    ];

    // Check if the URL contains any excluded extensions
    foreach ($excluded_extensions as $ext) {
      if (strpos($src, $ext) !== false) {
        return $src; // Keep query strings for these file types
      }
    }

    // Only remove version parameters from CSS/JS files and other safe resources
    if (strpos($src, '?ver=') !== false) {
      // Additional safety check: only remove from local resources or common CDNs
      $home_url = home_url();
      $safe_domains = [
        parse_url($home_url, PHP_URL_HOST), // Local domain
        'fonts.googleapis.com',
        'fonts.gstatic.com',
        'cdnjs.cloudflare.com',
        'ajax.googleapis.com',
      ];

      $src_host = parse_url($src, PHP_URL_HOST);
      if (in_array($src_host, $safe_domains) || empty($src_host)) {
        // Check if it's a CSS or JS file specifically
        if (preg_match('/\.(css|js)(\?|$)/', $src)) {
          $src = remove_query_arg('ver', $src);
        }
      }
    }

    return $src;
  }

  /**
   * Disable comments system-wide
   */
  private function disable_comments(): void
  {
    // Disable support for comments and trackbacks in post types
    add_action('admin_init', function () {
      $post_types = get_post_types();
      foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
          remove_post_type_support($post_type, 'comments');
          remove_post_type_support($post_type, 'trackbacks');
        }
      }
    });

    // Close comments on the frontend
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);

    // Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);

    // Remove comments page in menu
    add_action('admin_menu', function () {
      remove_menu_page('edit-comments.php');
    });

    // Remove comments links from admin bar
    add_action('init', function () {
      if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
      }
    });

    // Remove comment-related meta boxes
    add_action('admin_head', function () {
      remove_meta_box('commentsdiv', 'post', 'normal');
      remove_meta_box('commentstatusdiv', 'post', 'normal');
      remove_meta_box('trackbacksdiv', 'post', 'normal');
    });
  }

  /**
   * Disable automatic updates
   */
  private function disable_automatic_updates(): void
  {
    add_filter('automatic_updater_disabled', '__return_true');
    add_filter('allow_minor_auto_core_updates', '__return_false');
    add_filter('allow_major_auto_core_updates', '__return_false');
    add_filter('allow_dev_auto_core_updates', '__return_false');
    add_filter('auto_update_core', '__return_false');
    add_filter('wp_auto_update_core', '__return_false');
    add_filter('auto_update_plugin', '__return_false');
    add_filter('auto_update_theme', '__return_false');
    add_filter('automatic_updates_send_debug_email', '__return_false');
    add_filter('send_core_update_notification_email', '__return_false');
  }

  /**
   * Remove Gravatar defaults
   */
  public function remove_gravatar($avatar_defaults): array
  {
    return [];
  }

  /**
   * Replace Gravatar with simple placeholder
   */
  public function replace_gravatar($avatar, $id_or_email, $size, $default, $alt): string
  {
    $svg = '<svg width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect width="100" height="100" fill="#f0f0f0"/>
      <circle cx="50" cy="35" r="15" fill="#ccc"/>
      <path d="M25 75 C25 65, 35 55, 50 55 C65 55, 75 65, 75 75" fill="#ccc"/>
    </svg>';

    return '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" alt="' . esc_attr($alt) . '" class="avatar" width="' . esc_attr($size) . '" height="' . esc_attr($size) . '" />';
  }

  /**
   * Get current settings
   */
  public function get_settings(): array
  {
    return $this->settings;
  }

  /**
   * Disable RSS feeds completely
   */
  private function disable_rss_feeds(): void
  {
    // Remove feed links from <head>
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);

    // Redirect all feed URLs to homepage
    add_action('do_feed', [$this, 'disable_feed_redirect'], 1);
    add_action('do_feed_rdf', [$this, 'disable_feed_redirect'], 1);
    add_action('do_feed_rss', [$this, 'disable_feed_redirect'], 1);
    add_action('do_feed_rss2', [$this, 'disable_feed_redirect'], 1);
    add_action('do_feed_atom', [$this, 'disable_feed_redirect'], 1);
    add_action('do_feed_rss2_comments', [$this, 'disable_feed_redirect'], 1);
    add_action('do_feed_atom_comments', [$this, 'disable_feed_redirect'], 1);

    // Remove feed query var
    add_filter('query_vars', [$this, 'remove_feed_query_var']);
  }

  /**
   * Redirect feed requests to homepage
   */
  public function disable_feed_redirect(): void
  {
    wp_redirect(home_url(), 301);
    exit;
  }

  /**
   * Remove feed from query vars
   */
  public function remove_feed_query_var($query_vars): array
  {
    $feed_key = array_search('feed', $query_vars);
    if ($feed_key !== false) {
      unset($query_vars[$feed_key]);
    }
    return $query_vars;
  }

  /**
   * Remove embeds functionality
   */
  private function remove_embeds(): void
  {
    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed host JavaScript
    remove_action('wp_head', 'wp_oembed_add_host_js');

    // Disable oEmbed discovery
    add_filter('embed_oembed_discover', '__return_false');

    // Remove wp-embed.min.js script
    add_action('wp_footer', function () {
      wp_dequeue_script('wp-embed');
    });

    // Remove embed query var
    add_filter('query_vars', function ($query_vars) {
      $embed_key = array_search('embed', $query_vars);
      if ($embed_key !== false) {
        unset($query_vars[$embed_key]);
      }
      return $query_vars;
    });

    // Disable embed endpoint
    add_filter('rest_endpoints', function ($endpoints) {
      if (isset($endpoints['/oembed/1.0/embed'])) {
        unset($endpoints['/oembed/1.0/embed']);
      }
      return $endpoints;
    });
  }

  /**
   * Update settings and reinitialize
   */
  public function update_settings(array $new_settings): void
  {
    $this->settings = $new_settings;
  }



  /**
   * Dequeue non-sustainable scripts and styles
   */
  private function dequeue_non_sustainable(): void
  {
    // Remove wp-embed script (already handled by remove_embeds, but ensure it's gone)
    wp_deregister_script('wp-embed');
    wp_dequeue_script('wp-embed');

    // Remove block library styles if not using blocks heavily
    // Note: Only remove if not needed - be careful with this
    // wp_dequeue_style('wp-block-library');
    // wp_dequeue_style('wp-block-library-theme');

    // Remove comment-reply script if comments are disabled
    if (!empty($this->settings['disable_comments'])) {
      wp_deregister_script('comment-reply');
      wp_dequeue_script('comment-reply');
    }
  }
}
