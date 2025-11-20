<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Sustainability Settings Tester Class
 * 
 * Provides automated testing and verification of sustainability settings.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class SustainabilityTester
{
  private $settings;
  private $test_results = [];

  public function __construct()
  {
    $this->settings = get_option('sustainable_theme_settings', []);
  }

  /**
   * Run all tests
   * 
   * @return array Test results
   */
  public function run_all_tests(): array
  {
    $this->test_results = [];

    // Core WordPress Features
    $this->test_emoji_removal();
    $this->test_embed_removal();
    $this->test_header_metadata_removal();
    $this->test_rest_output_removal();
    $this->test_xmlrpc_disabled();
    $this->test_jquery_migrate_removal();

    // Performance Optimizations
    $this->test_shortlink_removal();
    $this->test_query_string_removal();
    $this->test_wp_version_removal();
    $this->test_dns_prefetch_removal();

    // Server Resource Management
    $this->test_heartbeat_disabled();
    $this->test_post_revisions_limit();

    // Feature Removal
    $this->test_comments_disabled();
    $this->test_rss_feed_disabled();
    $this->test_gravatar_disabled();

    // Frontend Optimizations
    $this->test_dashicons_disabled();
    $this->test_lazy_loading();

    // Security & Maintenance

    return $this->test_results;
  }

  /**
   * Test emoji removal
   */
  private function test_emoji_removal(): void
  {
    $enabled = !empty($this->settings['disable_emojis']);
    $has_action = has_action('wp_head', 'print_emoji_detection_script') === false;

    $this->test_results['disable_emojis'] = [
      'enabled' => $enabled,
      'action_removed' => $has_action,
      'status' => $enabled && $has_action ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_action ? 'Emojis successfully disabled' : 'Setting enabled but action still registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test embed removal
   */
  private function test_embed_removal(): void
  {
    $enabled = !empty($this->settings['remove_embeds']);
    $has_action = has_action('wp_head', 'wp_oembed_add_discovery_links') === false;

    $this->test_results['remove_embeds'] = [
      'enabled' => $enabled,
      'action_removed' => $has_action,
      'status' => $enabled && $has_action ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_action ? 'Embeds successfully removed' : 'Setting enabled but action still registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test header metadata removal
   */
  private function test_header_metadata_removal(): void
  {
    $enabled = !empty($this->settings['remove_header_metadata']);

    // Check if generator is removed
    $generator_removed = has_action('wp_head', 'wp_generator') === false;

    $this->test_results['remove_header_metadata'] = [
      'enabled' => $enabled,
      'generator_removed' => $generator_removed,
      'status' => $enabled && $generator_removed ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($generator_removed ? 'Header metadata removed' : 'Setting enabled but some metadata still present')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test REST output removal
   */
  private function test_rest_output_removal(): void
  {
    $enabled = !empty($this->settings['remove_rest_output']);
    $has_action = has_action('wp_head', 'rest_output_link_wp_head') === false;

    $this->test_results['remove_rest_output'] = [
      'enabled' => $enabled,
      'action_removed' => $has_action,
      'status' => $enabled && $has_action ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_action ? 'REST output removed' : 'Setting enabled but action still registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test XML-RPC disabled
   */
  private function test_xmlrpc_disabled(): void
  {
    $enabled = !empty($this->settings['disable_xmlrpc']);
    $xmlrpc_enabled = apply_filters('xmlrpc_enabled', true);

    $this->test_results['disable_xmlrpc'] = [
      'enabled' => $enabled,
      'xmlrpc_disabled' => !$xmlrpc_enabled,
      'status' => $enabled && !$xmlrpc_enabled ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? (!$xmlrpc_enabled ? 'XML-RPC disabled' : 'Setting enabled but XML-RPC still active')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test jQuery migrate removal
   */
  private function test_jquery_migrate_removal(): void
  {
    $enabled = !empty($this->settings['remove_jquery_migrate']);

    // Check if action is registered to remove jQuery migrate
    $has_action = has_action('wp_default_scripts', 'remove_jquery_migrate') !== false;
    // Also check for instance method
    global $wp_filter;
    $has_action_instance = false;
    if (isset($wp_filter['wp_default_scripts'])) {
      foreach ($wp_filter['wp_default_scripts']->callbacks as $priority => $callbacks) {
        foreach ($callbacks as $callback) {
          if (
            is_array($callback['function']) &&
            is_object($callback['function'][0]) &&
            method_exists($callback['function'][0], 'remove_jquery_migrate')
          ) {
            $has_action_instance = true;
            break 2;
          }
        }
      }
    }

    $action_registered = $has_action || $has_action_instance;

    $this->test_results['remove_jquery_migrate'] = [
      'enabled' => $enabled,
      'action_registered' => $action_registered,
      'status' => $enabled && $action_registered ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($action_registered ? 'jQuery migrate removal active' : 'Setting enabled but action not registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test shortlink removal
   */
  private function test_shortlink_removal(): void
  {
    $enabled = !empty($this->settings['remove_shortlinks']);
    $has_action = has_action('wp_head', 'wp_shortlink_wp_head') === false;

    $this->test_results['remove_shortlinks'] = [
      'enabled' => $enabled,
      'action_removed' => $has_action,
      'status' => $enabled && $has_action ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_action ? 'Shortlinks removed' : 'Setting enabled but action still registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test query string removal
   */
  private function test_query_string_removal(): void
  {
    $enabled = !empty($this->settings['remove_query_strings']);

    // Check if filter is registered (check for the method name since class instance may differ)
    $has_filter_script = has_filter('script_loader_src', 'remove_query_strings') !== false;
    $has_filter_style = has_filter('style_loader_src', 'remove_query_strings') !== false;
    // Also check for instance method
    $has_filter_instance = false;
    global $wp_filter;
    if (isset($wp_filter['script_loader_src'])) {
      foreach ($wp_filter['script_loader_src']->callbacks as $priority => $callbacks) {
        foreach ($callbacks as $callback) {
          if (
            is_array($callback['function']) &&
            is_object($callback['function'][0]) &&
            method_exists($callback['function'][0], 'remove_query_strings')
          ) {
            $has_filter_instance = true;
            break 2;
          }
        }
      }
    }

    $has_filter = $has_filter_script || $has_filter_style || $has_filter_instance;

    $this->test_results['remove_query_strings'] = [
      'enabled' => $enabled,
      'filter_registered' => $has_filter,
      'status' => $enabled && $has_filter ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_filter ? 'Query string removal active' : 'Setting enabled but filter not registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test WordPress version removal
   */
  private function test_wp_version_removal(): void
  {
    $enabled = !empty($this->settings['remove_wp_version']);
    $generator_removed = has_action('wp_head', 'wp_generator') === false;

    $this->test_results['remove_wp_version'] = [
      'enabled' => $enabled,
      'generator_removed' => $generator_removed,
      'status' => $enabled && $generator_removed ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($generator_removed ? 'WordPress version removed' : 'Setting enabled but generator still present')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test DNS prefetch removal
   */
  private function test_dns_prefetch_removal(): void
  {
    $enabled = !empty($this->settings['remove_dns_prefetch']);

    // Check if action is removed (wp_resource_hints should not be on wp_head)
    // Note: wp_resource_hints might be called elsewhere, so we check if it's removed from wp_head
    $has_action = has_action('wp_head', 'wp_resource_hints') === false;

    // Also verify the removal happens in frontend_optimizations
    global $wp_filter;
    $removal_confirmed = false;
    if (isset($wp_filter['wp_enqueue_scripts'])) {
      foreach ($wp_filter['wp_enqueue_scripts']->callbacks as $priority => $callbacks) {
        foreach ($callbacks as $callback) {
          if (
            is_array($callback['function']) &&
            is_object($callback['function'][0]) &&
            method_exists($callback['function'][0], 'frontend_optimizations')
          ) {
            $removal_confirmed = true;
            break 2;
          }
        }
      }
    }

    $this->test_results['remove_dns_prefetch'] = [
      'enabled' => $enabled,
      'action_removed' => $has_action || $removal_confirmed,
      'status' => $enabled && ($has_action || $removal_confirmed) ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? (($has_action || $removal_confirmed) ? 'DNS prefetch removal active' : 'Setting enabled but action still registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test heartbeat disabled
   */
  private function test_heartbeat_disabled(): void
  {
    $enabled = !empty($this->settings['disable_heartbeat']);

    // Check if action is registered to disable heartbeat
    $has_action_wp = has_action('wp_enqueue_scripts', 'disable_heartbeat') !== false;
    $has_action_admin = has_action('admin_enqueue_scripts', 'disable_heartbeat') !== false;
    // Also check for instance method
    global $wp_filter;
    $has_action_instance = false;
    foreach (['wp_enqueue_scripts', 'admin_enqueue_scripts', 'login_enqueue_scripts'] as $hook) {
      if (isset($wp_filter[$hook])) {
        foreach ($wp_filter[$hook]->callbacks as $priority => $callbacks) {
          foreach ($callbacks as $callback) {
            if (
              is_array($callback['function']) &&
              is_object($callback['function'][0]) &&
              method_exists($callback['function'][0], 'disable_heartbeat')
            ) {
              $has_action_instance = true;
              break 3;
            }
          }
        }
      }
    }

    $action_registered = $has_action_wp || $has_action_admin || $has_action_instance;

    $this->test_results['disable_heartbeat'] = [
      'enabled' => $enabled,
      'action_registered' => $action_registered,
      'status' => $enabled && $action_registered ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($action_registered ? 'Heartbeat disable action registered' : 'Setting enabled but action not registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test post revisions limit
   */
  private function test_post_revisions_limit(): void
  {
    $enabled = !empty($this->settings['limit_post_revisions']);
    $limit = $enabled ? (int) $this->settings['limit_post_revisions'] : null;

    $has_filter = has_filter('wp_revisions_to_keep') !== false;

    $this->test_results['limit_post_revisions'] = [
      'enabled' => $enabled,
      'limit' => $limit,
      'filter_registered' => $has_filter,
      'status' => $enabled && $has_filter ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_filter ? "Post revisions limited to {$limit}" : 'Setting enabled but filter not registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test comments disabled
   */
  private function test_comments_disabled(): void
  {
    $enabled = !empty($this->settings['disable_comments']);

    // Check if comments_open filter is registered
    $has_filter = has_filter('comments_open', '__return_false') !== false;

    $this->test_results['disable_comments'] = [
      'enabled' => $enabled,
      'filter_registered' => $has_filter,
      'status' => $enabled && $has_filter ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_filter ? 'Comments disabled' : 'Setting enabled but filter not registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test RSS feed disabled
   */
  private function test_rss_feed_disabled(): void
  {
    $enabled = !empty($this->settings['disable_rss_feed']);

    // Check if feed links are removed
    $feed_links_removed = has_action('wp_head', 'feed_links') === false;

    $this->test_results['disable_rss_feed'] = [
      'enabled' => $enabled,
      'feed_links_removed' => $feed_links_removed,
      'status' => $enabled && $feed_links_removed ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($feed_links_removed ? 'RSS feeds disabled' : 'Setting enabled but feed links still present')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test Gravatar disabled
   */
  private function test_gravatar_disabled(): void
  {
    $enabled = !empty($this->settings['disable_gravatar']);

    // Check if filter is registered
    $has_filter = has_filter('get_avatar') !== false;

    $this->test_results['disable_gravatar'] = [
      'enabled' => $enabled,
      'filter_registered' => $has_filter,
      'status' => $enabled && $has_filter ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($has_filter ? 'Gravatar disabled' : 'Setting enabled but filter not registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test Dashicons disabled
   */
  private function test_dashicons_disabled(): void
  {
    $enabled = !empty($this->settings['disable_dashicons_frontend']);

    // Check if frontend_optimizations method will handle this
    // Since it runs on wp_enqueue_scripts, we check if the method exists and setting is enabled
    $has_action = has_action('wp_enqueue_scripts', 'frontend_optimizations') !== false;
    // Also check for instance method
    global $wp_filter;
    $has_action_instance = false;
    if (isset($wp_filter['wp_enqueue_scripts'])) {
      foreach ($wp_filter['wp_enqueue_scripts']->callbacks as $priority => $callbacks) {
        foreach ($callbacks as $callback) {
          if (
            is_array($callback['function']) &&
            is_object($callback['function'][0]) &&
            method_exists($callback['function'][0], 'frontend_optimizations')
          ) {
            $has_action_instance = true;
            break 2;
          }
        }
      }
    }

    $action_registered = $has_action || $has_action_instance;

    $this->test_results['disable_dashicons_frontend'] = [
      'enabled' => $enabled,
      'action_registered' => $action_registered,
      'status' => $enabled && $action_registered ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($action_registered ? 'Dashicons removal active on frontend' : 'Setting enabled but action not registered')
        : 'Setting not enabled'
    ];
  }

  /**
   * Test lazy loading
   */
  private function test_lazy_loading(): void
  {
    $enabled = !empty($this->settings['enable_lazy_loading']);

    // Check if LazyLoading class is active
    $lazy_loading_active = class_exists('SustainableTheme\LazyLoading');

    $this->test_results['enable_lazy_loading'] = [
      'enabled' => $enabled,
      'class_active' => $lazy_loading_active,
      'status' => $enabled && $lazy_loading_active ? 'pass' : ($enabled ? 'partial' : 'not_tested'),
      'message' => $enabled
        ? ($lazy_loading_active ? 'Lazy loading enabled' : 'Setting enabled but class not active')
        : 'Setting not enabled'
    ];
  }


  /**
   * Get test results summary
   * 
   * @return array Summary statistics
   */
  public function get_summary(): array
  {
    $total = count($this->test_results);
    $passed = count(array_filter($this->test_results, fn($r) => $r['status'] === 'pass'));
    $partial = count(array_filter($this->test_results, fn($r) => $r['status'] === 'partial'));
    $not_tested = count(array_filter($this->test_results, fn($r) => $r['status'] === 'not_tested'));

    return [
      'total' => $total,
      'passed' => $passed,
      'partial' => $partial,
      'not_tested' => $not_tested,
      'success_rate' => $total > 0 ? round(($passed / $total) * 100, 2) : 0
    ];
  }

  /**
   * Get formatted test report
   * 
   * @return string HTML formatted report
   */
  public function get_formatted_report(): string
  {
    $summary = $this->get_summary();
    $html = '<div class="sustainability-test-report">';
    $html .= '<h2>Sustainability Settings Test Report</h2>';
    $html .= '<div class="test-summary">';
    $html .= '<p><strong>Total Tests:</strong> ' . $summary['total'] . '</p>';
    $html .= '<p><strong>Passed:</strong> ' . $summary['passed'] . '</p>';
    $html .= '<p><strong>Partial:</strong> ' . $summary['partial'] . '</p>';
    $html .= '<p><strong>Not Tested:</strong> ' . $summary['not_tested'] . '</p>';
    $html .= '<p><strong>Success Rate:</strong> ' . $summary['success_rate'] . '%</p>';
    $html .= '</div>';
    $html .= '<table class="test-results">';
    $html .= '<thead><tr><th>Setting</th><th>Status</th><th>Message</th></tr></thead>';
    $html .= '<tbody>';

    foreach ($this->test_results as $setting => $result) {
      $status_class = $result['status'];
      $html .= '<tr class="status-' . $status_class . '">';
      $html .= '<td>' . esc_html($setting) . '</td>';
      $html .= '<td><span class="status-badge status-' . $status_class . '">' . esc_html($result['status']) . '</span></td>';
      $html .= '<td>' . esc_html($result['message']) . '</td>';
      $html .= '</tr>';
    }

    $html .= '</tbody></table></div>';
    return $html;
  }
}
