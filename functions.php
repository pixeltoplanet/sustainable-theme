<?php

/**
 * The Sustainable Theme for WordPress
 *
 * @package SustainableTheme
 */

if (!defined('ABSPATH')) {
  exit;
}

// Define theme constants
define('SUSTAINABLE_THEME_VERSION', '0.5.0');
define('SUSTAINABLE_THEME_DIR', get_template_directory());
define('SUSTAINABLE_THEME_URL', get_template_directory_uri());

include_once get_template_directory() . '/includes/class-admin.php';
include_once get_template_directory() . '/includes/class-settings.php';
include_once get_template_directory() . '/includes/class-plugin-manager.php';
include_once get_template_directory() . '/includes/class-filesystem-manager.php';
include_once get_template_directory() . '/includes/class-rest-api-manager.php';
include_once get_template_directory() . '/includes/class-sustainability-optimizer.php';
include_once get_template_directory() . '/includes/class-database.php';
include_once get_template_directory() . '/includes/class-lazy-loading.php';
include_once get_template_directory() . '/includes/class-image-sizes.php';
include_once get_template_directory() . '/includes/class-grid-awareness.php';
include_once get_template_directory() . '/includes/class-logger.php';
include_once get_template_directory() . '/includes/class-settings-validator.php';
include_once get_template_directory() . '/includes/class-security-manager.php';
include_once get_template_directory() . '/includes/class-sustainability-tester.php';
include_once get_template_directory() . '/includes/class-design-settings.php';
include_once get_template_directory() . '/includes/class-block-patterns.php';
include_once get_template_directory() . '/includes/class-navigation.php';
include_once get_template_directory() . '/includes/class-query-exclude-current.php';
include_once get_template_directory() . '/includes/class-excerpt-hide-readmore.php';
include_once get_template_directory() . '/includes/class-video-block.php';
include_once get_template_directory() . '/includes/class-update-checker.php';

// Initialize the classes
new SustainableTheme\Settings();
new SustainableTheme\AdminMenu();
new SustainableTheme\SustainabilityOptimizer();
new SustainableTheme\Database();
new SustainableTheme\LazyLoading();
new SustainableTheme\Image_Sizes();
new SustainableTheme\GridAwareness();
new SustainableTheme\BlockPatterns();
new SustainableTheme\Navigation();
new SustainableTheme\DesignSettings();
new SustainableTheme\SecurityManager();
new SustainableTheme\UpdateChecker();

/**
 * Enqueue main frontend styles
 */
function sustainable_theme_enqueue_frontend_styles()
{
  wp_enqueue_style(
    'sustainable-theme-frontend-styles',
    SUSTAINABLE_THEME_URL . '/build/frontend-styles.css',
    [],
    SUSTAINABLE_THEME_VERSION
  );
}
add_action('wp_enqueue_scripts', 'sustainable_theme_enqueue_frontend_styles');

/**
 * Enqueue editor styles for both site editor and block editor
 */
function sustainable_theme_enqueue_editor_styles()
{
  add_editor_style('build/editor-styles.css');
}
add_action('after_setup_theme', 'sustainable_theme_enqueue_editor_styles');

/**
 * Block editor: extend core Query loop with "exclude current post" controls.
 */
function sustainable_theme_enqueue_query_block_script(): void
{
  $asset_path = SUSTAINABLE_THEME_DIR . '/build/query-block.asset.php';
  if (!is_readable($asset_path)) {
    return;
  }
  $asset = include $asset_path;
  wp_register_script(
    'sustainable-theme-query-block',
    SUSTAINABLE_THEME_URL . '/build/query-block.js',
    is_array($asset) ? ($asset['dependencies'] ?? []) : [],
    is_array($asset) ? (string) ($asset['version'] ?? SUSTAINABLE_THEME_VERSION) : SUSTAINABLE_THEME_VERSION,
    true
  );
  wp_enqueue_script('sustainable-theme-query-block');
}
add_action('enqueue_block_editor_assets', 'sustainable_theme_enqueue_query_block_script');

/**
 * Block editor: extend core Post Excerpt with "Hide Read More" toggle.
 */
function sustainable_theme_enqueue_excerpt_block_script(): void
{
  $asset_path = SUSTAINABLE_THEME_DIR . '/build/excerpt-block.asset.php';
  if (!is_readable($asset_path)) {
    return;
  }
  $asset = include $asset_path;
  wp_register_script(
    'sustainable-theme-excerpt-block',
    SUSTAINABLE_THEME_URL . '/build/excerpt-block.js',
    is_array($asset) ? ($asset['dependencies'] ?? []) : [],
    is_array($asset) ? (string) ($asset['version'] ?? SUSTAINABLE_THEME_VERSION) : SUSTAINABLE_THEME_VERSION,
    true
  );
  wp_enqueue_script('sustainable-theme-excerpt-block');
}
add_action('enqueue_block_editor_assets', 'sustainable_theme_enqueue_excerpt_block_script');

/**
 * Block editor: extend core Video with disabled autoplay controls.
 */
function sustainable_theme_enqueue_video_block_script(): void
{
  $asset_path = SUSTAINABLE_THEME_DIR . '/build/video-block.asset.php';
  if (!is_readable($asset_path)) {
    return;
  }
  $asset = include $asset_path;
  wp_register_script(
    'sustainable-theme-video-block',
    SUSTAINABLE_THEME_URL . '/build/video-block.js',
    is_array($asset) ? ($asset['dependencies'] ?? []) : [],
    is_array($asset) ? (string) ($asset['version'] ?? SUSTAINABLE_THEME_VERSION) : SUSTAINABLE_THEME_VERSION,
    true
  );

  // Expose theme settings the editor bundle needs. Inline (vs. an extra
  // REST fetch) keeps editor boot fast and is the lightest path.
  $settings = get_option('sustainable_theme_settings', []);
  $disable_autoplay = is_array($settings) && array_key_exists('disable_video_autoplay', $settings)
    ? (bool) $settings['disable_video_autoplay']
    : true; // Match class-settings.php default.

  wp_add_inline_script(
    'sustainable-theme-video-block',
    'window.sustainableTheme = window.sustainableTheme || {};'
      . ' window.sustainableTheme.disableVideoAutoplay = ' . ($disable_autoplay ? 'true' : 'false') . ';',
    'before'
  );

  wp_enqueue_script('sustainable-theme-video-block');
}
add_action('enqueue_block_editor_assets', 'sustainable_theme_enqueue_video_block_script');

/**
 * Get URL for a theme placeholder image.
 * Use for patterns that need consistent placeholder images without media library dependencies.
 *
 * @param string $slug Image slug. Maps to theme assets in assets/images/.
 * @return string Full URL to the image.
 */
function sustainable_theme_placeholder_image(string $slug = 'hero'): string
{
  $images = [
    'hero'         => 'coming-soon-bg-image.webp',
    'hero-boxed'   => 'northern-buttercups-flowers.webp',
    'square'       => 'botany-flowers.webp',
    'square-1'     => 'botany-flowers.webp',
    'portfolio-1'  => 'botany-flowers.webp',
    'portfolio-2'  => 'delphinium-flowers.webp',
    'portfolio-3'  => 'coming-soon-bg-image.webp',
    'portfolio-4'  => 'northern-buttercups-flowers.webp',
    'portfolio-5'  => 'botany-flowers.webp',
    'portfolio-6'  => 'delphinium-flowers.webp',
  ];
  $filename = $images[$slug] ?? 'coming-soon-bg-image.webp';
  return get_theme_file_uri("assets/images/{$filename}");
}

/**
 * Default navigation link blocks shipped with the theme.
 *
 * Renders inline core/navigation-link blocks so a fresh install always has a
 * working menu without depending on a wp_navigation post from another site.
 * Every item is a custom link pointing at the homepage; site owners can repoint
 * each item to a real page in the editor once their content exists.
 *
 * @return string Serialized navigation-link block markup.
 */
function sustainable_theme_default_navigation_links(): string
{
  $home = esc_url(home_url('/'));
  $items = [
    __('Home', 'sustainable-theme'),
    __('About', 'sustainable-theme'),
    __('Latest Work', 'sustainable-theme'),
    __('Contact', 'sustainable-theme'),
  ];

  $links = '';
  foreach ($items as $label) {
    $links .= sprintf(
      '<!-- wp:navigation-link {"label":"%1$s","url":"%2$s","kind":"custom","isTopLevelLink":true} /-->' . "\n",
      esc_attr($label),
      $home
    );
  }

  return $links;
}

/**
 * ID of the central "Main Menu" navigation post, created on demand.
 *
 * @return int Post ID, or 0 if unavailable.
 */
function sustainable_theme_main_menu_id(): int
{
  return \SustainableTheme\Navigation::get_main_menu_id();
}

/**
 * Render a core/navigation block wired to the shared Main Menu.
 *
 * Used by the header and footer patterns so every navigation references the
 * same menu (edit once, updates everywhere). If the menu post cannot be
 * created for some reason, the default links are inlined so the navigation is
 * never empty.
 *
 * @param array $attributes Navigation block attributes (styling, layout, etc.).
 * @return string Serialized core/navigation block markup.
 */
function sustainable_theme_navigation(array $attributes = []): string
{
  $flags   = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
  $menu_id = sustainable_theme_main_menu_id();

  if ($menu_id > 0) {
    $attributes = ['ref' => $menu_id] + $attributes;
    return sprintf('<!-- wp:navigation %s /-->', wp_json_encode($attributes, $flags));
  }

  return sprintf(
    "<!-- wp:navigation %s -->\n%s<!-- /wp:navigation -->",
    wp_json_encode($attributes, $flags),
    sustainable_theme_default_navigation_links()
  );
}
