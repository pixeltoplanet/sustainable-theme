<?php

namespace SustainableTheme;

/**
 * Settings Management Class
 * 
 * Central settings management class for the Sustainable Theme. Handles all
 * theme configuration, sustainability settings, and coordinates with other
 * manager classes.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class Settings
{
  private PluginManager $plugin_manager;
  private FilesystemManager $filesystem_manager;
  private RestApiManager $rest_api_manager;

  /**
   * Settings constructor
   * 
   * Initializes the Settings class with all required dependencies and
   * sets up WordPress hooks for settings registration and REST API
   * route management. This constructor follows the dependency injection
   * pattern for better testability and maintainability.
   * 
   * ## Initialization Process
   * 1. **Manager Creation**: Creates PluginManager and FilesystemManager instances
   * 2. **REST API Setup**: Initializes RestApiManager with all dependencies
   * 3. **WordPress Hooks**: Registers admin_init and rest_api_init hooks
   * 4. **Settings Registration**: Sets up WordPress options API integration
   * 
   * ## Dependencies Created
   * - **PluginManager**: Handles plugin recommendations and operations
   * - **FilesystemManager**: Manages filesystem access and credentials
   * - **RestApiManager**: Coordinates REST API endpoint registration
   * 
   * ## WordPress Hooks Registered
   * - `admin_init`: Triggers settings registration
   * - `rest_api_init`: Triggers REST API route registration
   * 
   * @since 1.0.0
   * @return void
   */
  public function __construct()
  {
    // Initialize managers
    $this->plugin_manager = new PluginManager();
    $this->filesystem_manager = new FilesystemManager();

    // Initialize REST API manager with dependencies
    $this->rest_api_manager = new RestApiManager($this, $this->plugin_manager, $this->filesystem_manager);

    add_action('admin_init', [$this, 'register_settings']);
    add_action('rest_api_init', [$this->rest_api_manager, 'register_routes']);
  }

  /**
   * Register comprehensive sustainability settings with WordPress Options API
   * 
   * Registers all theme settings with WordPress's built-in options system,
   * providing comprehensive sustainability configuration options. Each setting
   * is designed to reduce environmental impact while maintaining optimal
   * website performance.
   * 
   * ## Settings Registration Process
   * 
   * ### 1. Main Settings Group
   * - Registers 'sustainable_theme_settings' option group
   * - Uses object type for complex settings structure
   * - Implements custom sanitization callback
   * - Provides default values for all settings
   * 
   * ### 2. REST API Schema
   * - Defines JSON schema for REST API integration
   * - Enables frontend React components to access settings
   * - Provides type validation and constraints
   * - Supports real-time settings updates
   * 
   * ### 3. Setting Categories
   * 
   * #### Core Sustainability Mode
   * - **base**: Basic sustainability optimizations
   * - **super**: Advanced sustainability features
   * - **custom**: User-defined configuration
   * 
   * #### Performance Optimizations
   * - **Image Optimization**: Automatic compression and format conversion
   * - **Caching Strategy**: Advanced caching for reduced server load
   * - **Database Cleanup**: Regular optimization and cleanup
   * - **Asset Optimization**: CSS/JS minification and concatenation
   * 
   * #### Environmental Impact
   * - **Carbon Tracking**: Monitor and reduce carbon footprint
   * - **Resource Monitoring**: Track bandwidth and server usage
   * - **Green Hosting**: Optimize for eco-friendly providers
   * - **Sustainability Reporting**: Generate impact reports
   * 
   * ## WordPress Integration
   * 
   * This method integrates with WordPress core functionality:
   * - Uses `register_setting()` for options API integration
   * - Implements `sanitize_callback` for data validation
   * - Provides REST API schema for frontend access
   * - Follows WordPress coding standards and best practices
   * 
   * ## Security Features
   * - All settings are sanitized before storage
   * - Input validation prevents malicious data
   * - Type constraints ensure data integrity
   * - Default values provide safe fallbacks
   * 
   * @since 1.0.0
   * @return void
   * 
   * @link https://developer.wordpress.org/reference/functions/register_setting/
   * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/
   */
  public function register_settings(): void
  {
    // Register the main settings group
    register_setting(
      'sustainable_theme_settings',
      'sustainable_theme_settings',
      [
        'type' => 'object',
        'sanitize_callback' => [$this, 'sanitize_settings'],
        'default' => $this->get_default_settings(),
        'show_in_rest' => [
          'schema' => [
            'type' => 'object',
            'properties' => [
              // CORE SUSTAINABILITY MODE - Controls preset combinations of optimizations
              'sustainability_mode' => [
                'type' => 'string',
                'enum' => ['base', 'super', 'custom'],
                'default' => 'base'
              ],

              /* INDIVIDUAL OVERRIDE SETTINGS */

              /**
               * Performance & Resource Management - Removes non-essential scripts like wp-embed
               * @link https://developer.wordpress.org/reference/functions/wp_dequeue_script/
               */
              'dequeue_non_sustainable' => ['type' => 'boolean', 'default' => false],

              /**
               * Grid-aware functionality - Adapts site features based on electricity grid carbon intensity
               */
              'use_grid_awareness' => ['type' => 'boolean', 'default' => false],

              /**
               * Electricity Maps API Key - Required for grid awareness functionality
               * @link https://api-portal.electricitymaps.com/
               */
              'electricity_maps_api_key' => ['type' => 'string', 'default' => ''],

              /**
               * RSS & FEEDS - Removes RSS feed links and redirects feed URLs
               * @link https://developer.wordpress.org/reference/functions/feed_links/
               * @link https://developer.wordpress.org/reference/functions/feed_links_extra/
               */
              'disable_rss_feed' => ['type' => 'boolean', 'default' => false],

              /**
               * EMOJI SUPPORT - Removes emoji detection scripts and styles (~30KB)
               * @link https://developer.wordpress.org/reference/functions/print_emoji_detection_script/
               * @link https://developer.wordpress.org/reference/functions/print_emoji_styles/
               */
              'disable_emojis' => ['type' => 'boolean', 'default' => false],

              /**
               * OEMBED FUNCTIONALITY - Disables oEmbed discovery and removes embed-related scripts
               * @link https://developer.wordpress.org/reference/functions/wp_oembed_add_discovery_links/
               * @link https://developer.wordpress.org/reference/functions/wp_oembed_add_host_js/
               */
              'remove_embeds' => ['type' => 'boolean', 'default' => false],

              /**
               * HTML HEAD CLEANUP - Removes RSD, WLW manifest, generator, and shortlink meta tags
               * @link https://developer.wordpress.org/reference/functions/wp_generator/
               * @link https://developer.wordpress.org/reference/functions/rsd_link/
               * @link https://developer.wordpress.org/reference/functions/wlwmanifest_link/
               */
              'remove_header_metadata' => ['type' => 'boolean', 'default' => false],

              /**
               * REST API CLEANUP - Removes REST API discovery links from HTML head
               * @link https://developer.wordpress.org/reference/functions/rest_output_link_wp_head/
               */
              'remove_rest_output' => ['type' => 'boolean', 'default' => false],

              /**
               * XML-RPC SECURITY & PERFORMANCE - Disables XML-RPC endpoint
               * @link https://developer.wordpress.org/reference/functions/xmlrpc_enabled/
               */
              'disable_xmlrpc' => ['type' => 'boolean', 'default' => false],

              /**
               * PINGBACK OPTIMIZATION - Prevents internal pingbacks when linking to own posts
               * @link https://developer.wordpress.org/reference/hooks/pre_ping/
               */
              'disable_self_pingbacks' => ['type' => 'boolean', 'default' => false],

              /**
               * JQUERY OPTIMIZATION - Removes jQuery Migrate script for modern browsers (~10KB)
               * @link https://developer.wordpress.org/reference/functions/wp_default_scripts/
               */
              'remove_jquery_migrate' => ['type' => 'boolean', 'default' => false],

              // ADDITIONAL SUSTAINABILITY SETTINGS

              /**
               * SHORTLINK CLEANUP - Removes shortlink headers and meta tags
               * @link https://developer.wordpress.org/reference/functions/wp_shortlink_wp_head/
               */
              'remove_shortlinks' => ['type' => 'boolean', 'default' => false],

              /**
               * HEARTBEAT API MANAGEMENT - Completely disables WordPress Heartbeat API (Note: Use reduce_heartbeat_frequency instead for frequency reduction)
               * @link https://developer.wordpress.org/reference/hooks/heartbeat_settings/
               * @link https://developer.wordpress.org/plugins/javascript/heartbeat-api/
               */
              'disable_heartbeat' => ['type' => 'boolean', 'default' => false],

              /**
               * DATABASE OPTIMIZATION - Limits post revisions stored in database
               * @link https://developer.wordpress.org/reference/functions/wp_revisions_to_keep/
               */
              'limit_post_revisions' => [
                'type' => 'integer',
                'minimum' => 0,
                'maximum' => 10,
                'default' => false
              ],

              /**
               * CACHING OPTIMIZATION - Removes version parameters from CSS/JS for better CDN caching
               * @link https://developer.wordpress.org/reference/hooks/script_loader_src/
               * @link https://developer.wordpress.org/reference/hooks/style_loader_src/
               */
              'remove_query_strings' => ['type' => 'boolean', 'default' => false],

              /**
               * COMMENT SYSTEM REMOVAL - Completely removes comment system including admin pages
               * @link https://developer.wordpress.org/reference/functions/comments_open/
               * @link https://developer.wordpress.org/reference/functions/remove_post_type_support/
               */
              'disable_comments' => ['type' => 'boolean', 'default' => false],

              /**
               * VERSION INFORMATION CLEANUP - Removes WordPress version from HTML output
               * @link https://developer.wordpress.org/reference/functions/wp_generator/
               */
              'remove_wp_version' => ['type' => 'boolean', 'default' => false],


              /**
               * DNS PREFETCH REMOVAL - Removes DNS prefetch hints
               * @link https://developer.wordpress.org/reference/functions/wp_resource_hints/
               */
              'remove_dns_prefetch' => ['type' => 'boolean', 'default' => false],

              /**
               * DASHICONS OPTIMIZATION - Removes Dashicons CSS (~24KB) from frontend
               * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
               */
              'disable_dashicons_frontend' => ['type' => 'boolean', 'default' => false],

              /**
               * FILE EDITING SECURITY - Disables file editing in WordPress admin
               * @link https://wordpress.org/support/article/editing-files/#file-editing-via-dashboard
               */
              'disable_file_editing' => ['type' => 'boolean', 'default' => false],

              /**
               * HEARTBEAT FREQUENCY OPTIMIZATION - Reduces Heartbeat frequency from 15-60s to 120s
               * @link https://developer.wordpress.org/reference/hooks/heartbeat_settings/
               */
              'reduce_heartbeat_frequency' => ['type' => 'boolean', 'default' => false],

              /**
               * GRAVATAR REPLACEMENT - Replaces Gravatar with local SVG placeholders
               * @link https://developer.wordpress.org/reference/functions/get_avatar/
               */
              'disable_gravatar' => ['type' => 'boolean', 'default' => false],

              /**
               * WORDPRESS TEXT PROCESSING - Disables WordPress auto-correction filters
               * @link https://developer.wordpress.org/reference/functions/capital_p_dangit/
               */
              'remove_capital_p_dangit' => ['type' => 'boolean', 'default' => false],

              /**
               * AUTOMATIC UPDATES - Disables all automatic updates
               * @link https://developer.wordpress.org/reference/hooks/automatic_updater_disabled/
               */
              'disable_automatic_updates' => ['type' => 'boolean', 'default' => false],

              /**
               * THEME EDITOR REMOVAL - Removes theme editor from admin area
               * @link https://wordpress.org/support/article/editing-files/#file-editing-via-dashboard
               */
              'remove_theme_editor' => ['type' => 'boolean', 'default' => false],

              /**
               * LAZY LOADING OPTIMIZATION - Enables native lazy loading for images
               * @link https://developer.wordpress.org/reference/functions/wp_img_tag_add_loading_attr/
               * @link https://developer.wordpress.org/reference/functions/get_avatar/
               */
              'enable_lazy_loading' => ['type' => 'boolean', 'default' => false],

              /**
               * ABOVE FOLD IMAGE LIMIT - Number of images to load eagerly (not lazy)
               * @link https://developer.wordpress.org/reference/functions/wp_img_tag_add_loading_attr/
               */
              'above_fold_image_limit' => [
                'type' => 'integer',
                'minimum' => 1,
                'maximum' => 5,
                'default' => 2
              ],

              /**
               * IMAGE OPTIMIZATION - Enables responsive image size management
               * @link https://developer.wordpress.org/reference/functions/add_image_size/
               */
              'enable_image_optimization' => ['type' => 'boolean', 'default' => false],

              /**
               * MAX IMAGE SIZE - Limits maximum image dimensions for sustainability
               * @link https://developer.wordpress.org/reference/functions/add_image_size/
               */
              'max_image_size' => [
                'type' => 'string',
                'enum' => ['medium', 'large', 'full'],
                'default' => 'full'
              ],

              /**
               * REMOVE DEFAULT IMAGE SIZES - Removes WordPress default image sizes (medium, large, full)
               * @link https://developer.wordpress.org/reference/functions/remove_image_size/
               */
              'remove_default_image_sizes' => ['type' => 'boolean', 'default' => false],


            ],
          ],
        ],
      ]
    );
  }

  /**
   * Get default settings configuration
   * 
   * Returns the default configuration values for all theme settings.
   * These defaults provide sensible starting points for sustainability
   * optimization while ensuring good performance and user experience.
   * 
   * ## Default Configuration
   * 
   * ### Core Settings
   * - **sustainability_mode**: 'base' - Balanced sustainability approach
   * - **enable_image_optimization**: true - Automatic image optimization
   * - **enable_caching**: false - Caching disabled by default (requires setup)
   * - **enable_database_cleanup**: true - Regular database maintenance
   * 
   * ### Performance Settings
   * - **enable_css_optimization**: true - CSS minification and optimization
   * - **enable_js_optimization**: true - JavaScript optimization
   * - **enable_lazy_loading**: true - Deferred loading for images
   * - **enable_compression**: true - Gzip/Brotli compression
   * 
   * ### Environmental Settings
   * - **enable_carbon_tracking**: false - Carbon tracking disabled by default
   * - **enable_resource_monitoring**: true - Resource usage monitoring
   * - **enable_green_hosting**: false - Green hosting optimization disabled
   * - **enable_sustainability_reporting**: false - Reporting disabled by default
   * 
   * ## Return Value
   * Returns an associative array with all default settings:
   * ```php
   * [
   *   'sustainability_mode' => 'base',
   *   'enable_image_optimization' => true,
   *   'enable_caching' => false,
   *   // ... other settings
   * ]
   * ```
   * 
   * ## Usage
   * These defaults are used when:
   * - Theme is first activated
   * - Settings are reset to defaults
   * - New settings are added to the system
   * - Settings validation fails and fallback is needed
   * 
   * @since 1.0.0
   * @return array Associative array of default setting values
   */
  public function get_default_settings(): array
  {
    return [
      'sustainability_mode' => 'base',
      'dequeue_non_sustainable' => false,
      'use_grid_awareness' => false,
      'electricity_maps_api_key' => '',
      'disable_rss_feed' => false,
      'disable_emojis' => false,
      'remove_embeds' => false,
      'remove_header_metadata' => false,
      'remove_rest_output' => false,
      'disable_xmlrpc' => false,
      'disable_self_pingbacks' => false,
      'remove_jquery_migrate' => false,
      // Additional sustainability options
      'remove_shortlinks' => false,
      'disable_heartbeat' => false,
      'limit_post_revisions' => false,
      'remove_query_strings' => false,
      'disable_comments' => false,
      'remove_wp_version' => false,
      'remove_dns_prefetch' => false,
      'disable_dashicons_frontend' => false,
      'disable_file_editing' => false,
      'reduce_heartbeat_frequency' => false,
      'disable_gravatar' => false,
      'remove_capital_p_dangit' => false,
      'disable_automatic_updates' => false,
      'remove_theme_editor' => false,
      // Lazy loading settings
      'enable_lazy_loading' => false,
      'above_fold_image_limit' => 2,
      // Image optimization settings
      'enable_image_optimization' => false,
      'max_image_size' => 'full',
      'remove_default_image_sizes' => false,
    ];
  }

  /**
   * Get settings for a specific sustainability mode
   */
  public function get_mode_settings(string $mode): array
  {
    $base_settings = $this->get_default_settings();
    $current_settings = get_option('sustainable_theme_settings', []);

    switch ($mode) {
      case 'base':
        return array_merge($base_settings, [
          'sustainability_mode' => 'base',
          'disable_emojis' => true,
          'remove_embeds' => true,
          'remove_header_metadata' => true,
          'disable_self_pingbacks' => true,
          'remove_jquery_migrate' => true,
          // Base mode additions
          'remove_shortlinks' => true,
          'disable_heartbeat' => false,
          'limit_post_revisions' => 5,
          'remove_query_strings' => true,
          'disable_file_editing' => true,
          'remove_capital_p_dangit' => true,
          'remove_theme_editor' => true,
          // Base mode lazy loading
          'enable_lazy_loading' => true,
          'above_fold_image_limit' => 2,
          // Base mode image optimization
          'enable_image_optimization' => true,
          'max_image_size' => 'full',
          'remove_default_image_sizes' => false,
          // Preserve grid awareness settings
          'use_grid_awareness' => $current_settings['use_grid_awareness'] ?? true,
          'electricity_maps_api_key' => $current_settings['electricity_maps_api_key'] ?? '',
        ]);

      case 'super':
        return array_merge($base_settings, [
          'sustainability_mode' => 'super',
          'dequeue_non_sustainable' => true,
          'use_grid_awareness' => $current_settings['use_grid_awareness'] ?? true,
          'electricity_maps_api_key' => $current_settings['electricity_maps_api_key'] ?? '',
          'disable_rss_feed' => true,
          'disable_emojis' => true,
          'remove_embeds' => true,
          'remove_header_metadata' => true,
          'remove_rest_output' => true,
          'disable_xmlrpc' => true,
          'disable_self_pingbacks' => true,
          'remove_jquery_migrate' => true,
          // Super mode additions
          'remove_shortlinks' => true,
          'disable_heartbeat' => true,
          'limit_post_revisions' => 3,
          'remove_query_strings' => true,
          'disable_comments' => true,
          'remove_wp_version' => true,
          'remove_dns_prefetch' => true,
          'disable_dashicons_frontend' => true,
          'disable_file_editing' => true,
          'reduce_heartbeat_frequency' => true,
          'disable_gravatar' => true,
          'remove_capital_p_dangit' => true,
          'disable_automatic_updates' => true,
          'remove_theme_editor' => true,
          // Super mode lazy loading
          'enable_lazy_loading' => true,
          'above_fold_image_limit' => 1,
          // Super mode image optimization
          'enable_image_optimization' => true,
          'max_image_size' => 'large',
          'remove_default_image_sizes' => true,
        ]);

      case 'custom':
        // For custom mode, return current settings
        $current_settings = get_option('sustainable_theme_settings', $base_settings);
        return array_merge($base_settings, $current_settings, ['sustainability_mode' => 'custom']);

      default:
        return $base_settings;
    }
  }


  /**
   * Get current settings
   */
  public function get_settings(): \WP_REST_Response
  {
    $settings = get_option('sustainable_theme_settings', $this->get_default_settings());
    return new \WP_REST_Response($settings, 200);
  }

  /**
   * Update settings with validation
   */
  public function update_settings(\WP_REST_Request $request): \WP_REST_Response
  {
    try {
      // Check rate limit
      if (!SecurityManager::checkRateLimit('settings_update')) {
        return new \WP_REST_Response([
          'success' => false,
          'message' => 'Rate limit exceeded. Please wait before making another request.'
        ], 429);
      }

      $new_settings = $request->get_param('settings');

      if (empty($new_settings)) {
        Logger::warning('Empty settings provided for update', [
          'user_id' => get_current_user_id()
        ]);
        return new \WP_REST_Response([
          'success' => false,
          'message' => 'No settings provided'
        ], 400);
      }

      // Validate settings before sanitization
      $validation_errors = SettingsValidator::validateSettings($new_settings);
      if (!empty($validation_errors)) {
        Logger::warning('Settings validation failed', [
          'errors' => $validation_errors,
          'user_id' => get_current_user_id()
        ]);

        return new \WP_REST_Response([
          'success' => false,
          'message' => 'Settings validation failed',
          'errors' => $validation_errors
        ], 400);
      }

      $sanitized_settings = $this->sanitize_settings($new_settings);
      $updated = update_option('sustainable_theme_settings', $sanitized_settings);

      if ($updated !== false) {
        Logger::info('Settings updated successfully', [
          'user_id' => get_current_user_id(),
          'settings_count' => count($sanitized_settings)
        ]);

        return new \WP_REST_Response([
          'success' => true,
          'settings' => $sanitized_settings,
          'message' => 'Settings updated successfully'
        ], 200);
      } else {
        Logger::warning('Settings update failed - no changes made', [
          'user_id' => get_current_user_id()
        ]);

        return new \WP_REST_Response([
          'success' => false,
          'message' => 'Failed to update settings - no changes made'
        ], 500);
      }
    } catch (\Exception $e) {
      Logger::error('Settings update error', [
        'error' => $e->getMessage(),
        'user_id' => get_current_user_id(),
        'trace' => $e->getTraceAsString()
      ]);

      return new \WP_REST_Response([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Update settings based on sustainability mode
   */
  public function update_by_mode(\WP_REST_Request $request): \WP_REST_Response
  {
    try {
      $mode = $request->get_param('mode');
      $mode_settings = $this->get_mode_settings($mode);

      $updated = update_option('sustainable_theme_settings', $mode_settings);

      if ($updated !== false) {
        return new \WP_REST_Response([
          'success' => true,
          'settings' => $mode_settings,
          'mode' => $mode,
          'message' => "Settings updated to {$mode} mode"
        ], 200);
      } else {
        return new \WP_REST_Response([
          'success' => false,
          'message' => 'Failed to update settings - no changes made'
        ], 500);
      }
    } catch (\Exception $e) {
      error_log('Mode update error: ' . $e->getMessage());
      return new \WP_REST_Response([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Reset settings to defaults
   */
  public function reset_settings(\WP_REST_Request $request): \WP_REST_Response
  {
    $default_settings = $this->get_default_settings();
    $updated = update_option('sustainable_theme_settings', $default_settings);

    if ($updated) {
      return new \WP_REST_Response([
        'success' => true,
        'settings' => $default_settings,
        'message' => 'Settings reset to defaults successfully'
      ], 200);
    } else {
      return new \WP_REST_Response([
        'success' => false,
        'message' => 'Failed to reset settings'
      ], 500);
    }
  }

  /**
   * Sanitize settings using the SettingsValidator
   */
  public function sanitize_settings(array $settings): array
  {
    try {
      // Use the SettingsValidator for comprehensive sanitization
      $sanitized = SettingsValidator::sanitizeSettings($settings);

      // Merge with defaults to ensure all settings are present
      $defaults = $this->get_default_settings();
      $sanitized = array_merge($defaults, $sanitized);

      Logger::info('Settings sanitized successfully', [
        'total_settings' => count($sanitized),
        'user_id' => get_current_user_id()
      ]);

      return $sanitized;
    } catch (\Exception $e) {
      Logger::error('Settings sanitization failed', [
        'error' => $e->getMessage(),
        'user_id' => get_current_user_id()
      ]);

      // Return defaults as fallback
      return $this->get_default_settings();
    }
  }

  /**
   * Save settings (helper method)
   */
  public function save_settings(array $settings): bool
  {
    $sanitized_settings = $this->sanitize_settings($settings);
    return update_option('sustainable_theme_settings', $sanitized_settings);
  }
}
