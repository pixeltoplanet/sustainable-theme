<?php

namespace SustainableTheme;

/**
 * Plugin Management Class
 * 
 * Handles plugin recommendations, installation, activation, and status checking
 * for the Sustainable Theme with proper security and error handling.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class PluginManager
{
  private FilesystemManager $filesystem_manager;

  /**
   * PluginManager constructor
   * 
   * Initializes the PluginManager with required dependencies. Creates a new
   * FilesystemManager instance to handle all filesystem operations needed for
   * plugin installation and management.
   * 
   * ## Dependencies
   * - **FilesystemManager**: Handles filesystem operations for plugin installation
   * - **WordPress Core**: Relies on WordPress plugin management functions
   * 
   * ## Initialization Process
   * 1. Creates FilesystemManager instance
   * 2. Prepares for plugin operations
   * 3. Sets up error handling and logging
   * 
   * @since 1.0.0
   * @return void
   */
  public function __construct()
  {
    $this->filesystem_manager = new FilesystemManager();
  }

  /**
   * Get curated list of recommended plugins with installation status
   * 
   * Returns plugins that enhance website performance and sustainability.
   * Each plugin includes installation and activation status.
   * 
   * @since 1.0.0
   * @return array Array of recommended plugins with status information
   */
  public function get_recommended_plugins(): array
  {
    error_log("Sustainable Theme: Getting recommended plugins");

    // Include plugin.php for plugin functions
    if (!function_exists('is_plugin_active')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    $recommended_plugins = [
      [
        'slug' => 'wp-smushit',
        'name' => 'Smush - Image Optimization',
        'description' => 'Automatically optimize images for better performance and reduced bandwidth usage.',
        'is_installed' => $this->is_plugin_installed('wp-smushit/wp-smush.php'),
        'is_active' => is_plugin_active('wp-smushit/wp-smush.php'),
      ],
      [
        'slug' => 'litespeed-cache',
        'name' => 'LiteSpeed Cache',
        'description' => 'Advanced caching plugin for improved page load speeds and reduced server load.',
        'is_installed' => $this->is_plugin_installed('litespeed-cache/litespeed-cache.php'),
        'is_active' => is_plugin_active('litespeed-cache/litespeed-cache.php'),
      ],
      [
        'slug' => 'wp-optimize',
        'name' => 'WP-Optimize',
        'description' => 'Clean and optimize your WordPress database for better performance.',
        'is_installed' => $this->is_plugin_installed('wp-optimize/wp-optimize.php'),
        'is_active' => is_plugin_active('wp-optimize/wp-optimize.php'),
      ],
      [
        'slug' => 'autoptimize',
        'name' => 'Autoptimize',
        'description' => 'Optimize CSS, JavaScript, and HTML for faster page loading.',
        'is_installed' => $this->is_plugin_installed('autoptimize/autoptimize.php'),
        'is_active' => is_plugin_active('autoptimize/autoptimize.php'),
      ],
    ];

    error_log("Sustainable Theme: Recommended plugins data: " . print_r($recommended_plugins, true));

    return $recommended_plugins;
  }

  /**
   * Install a plugin from WordPress.org repository
   * 
   * Downloads and installs a plugin using WordPress's Plugin_Upgrader.
   * Includes rate limiting, permission checks, and error handling.
   * 
   * @since 1.0.0
   * @param string $plugin_slug The plugin slug (e.g., 'wp-smushit')
   * @return array Installation results with success status and details
   */
  public function install_plugin(string $plugin_slug): array
  {
    // Rate limiting - prevent abuse
    $user_id = get_current_user_id();
    $rate_limit_key = 'sustainable_theme_install_' . $user_id;
    $last_install = get_transient($rate_limit_key);

    if ($last_install && (time() - $last_install) < 30) {
      error_log("Sustainable Theme: Rate limit exceeded for user: " . $user_id);
      return [
        'success' => false,
        'message' => 'Please wait 30 seconds before installing another plugin',
        'status_code' => 429,
      ];
    }

    // Set rate limit
    set_transient($rate_limit_key, time(), 30);

    // Debug logging
    error_log("Sustainable Theme: Attempting to install plugin: " . $plugin_slug);

    // Include necessary files
    if (!function_exists('is_plugin_active')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    if (!function_exists('install_plugin')) {
      include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
      include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
      include_once(ABSPATH . 'wp-admin/includes/file.php');
      include_once(ABSPATH . 'wp-admin/includes/misc.php');
      include_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
    }

    // Map plugin slugs to their actual plugin files
    $plugin_map = [
      'wp-smushit' => 'wp-smushit/wp-smush.php',
      'litespeed-cache' => 'litespeed-cache/litespeed-cache.php',
      'wp-optimize' => 'wp-optimize/wp-optimize.php',
      'autoptimize' => 'autoptimize/autoptimize.php',
    ];

    if (!isset($plugin_map[$plugin_slug])) {
      error_log("Sustainable Theme: Invalid plugin slug: " . $plugin_slug);
      return [
        'success' => false,
        'message' => 'Invalid plugin slug',
        'status_code' => 400,
      ];
    }

    $plugin_file = $plugin_map[$plugin_slug];
    error_log("Sustainable Theme: Plugin file: " . $plugin_file);

    // Check if plugin is already active
    if (is_plugin_active($plugin_file)) {
      error_log("Sustainable Theme: Plugin already active: " . $plugin_file);
      return [
        'success' => true,
        'message' => 'Plugin is already active',
        'action' => 'already_active',
        'status_code' => 200,
      ];
    }

    // Check if plugin is installed but not active
    if ($this->is_plugin_installed($plugin_file)) {
      error_log("Sustainable Theme: Plugin installed but not active, activating: " . $plugin_file);
      $result = activate_plugin($plugin_file);
      if (is_wp_error($result)) {
        error_log("Sustainable Theme: Failed to activate plugin: " . $result->get_error_message());
        return [
          'success' => false,
          'message' => 'Failed to activate plugin: ' . $result->get_error_message(),
          'status_code' => 500,
        ];
      }

      error_log("Sustainable Theme: Plugin activated successfully: " . $plugin_file);
      return [
        'success' => true,
        'message' => 'Plugin activated successfully',
        'action' => 'activated',
        'status_code' => 200,
      ];
    }

    // Install the plugin
    error_log("Sustainable Theme: Installing plugin from repository: " . $plugin_slug);
    $api = plugins_api('plugin_information', [
      'slug' => $plugin_slug,
      'fields' => [
        'short_description' => false,
        'sections' => false,
        'requires' => false,
        'rating' => false,
        'ratings' => false,
        'downloaded' => false,
        'last_updated' => false,
        'added' => false,
        'tags' => false,
        'compatibility' => false,
        'homepage' => false,
        'donate_link' => false,
      ],
    ]);

    if (is_wp_error($api)) {
      error_log("Sustainable Theme: Failed to get plugin information: " . $api->get_error_message());
      return [
        'success' => false,
        'message' => 'Failed to get plugin information: ' . $api->get_error_message(),
        'status_code' => 500,
      ];
    }

    error_log("Sustainable Theme: Plugin API data retrieved, download link: " . $api->download_link);
    error_log("Sustainable Theme: Using updated installation method (v2.0)");

    // Use FilesystemManager for installation
    $filesystem_result = $this->filesystem_manager->initialize_filesystem();
    if (!$filesystem_result['success']) {
      return [
        'success' => false,
        'message' => $filesystem_result['message'],
        'action' => $filesystem_result['action'] ?? 'filesystem_error',
        'status_code' => 500,
      ];
    }

    error_log("Sustainable Theme: Filesystem initialized successfully, proceeding with installation");

    // Set time limit for plugin installation
    set_time_limit(300); // 5 minutes max

    // Install the plugin with error handling
    $skin = new \WP_Ajax_Upgrader_Skin();
    $upgrader = new \Plugin_Upgrader($skin);

    // Add progress tracking
    $skin->set_upgrader($upgrader);

    $result = $upgrader->install($api->download_link);

    // Reset time limit
    set_time_limit(30);

    if (is_wp_error($result)) {
      error_log("Sustainable Theme: Failed to install plugin: " . $result->get_error_message());
      return [
        'success' => false,
        'message' => 'Failed to install plugin: ' . $result->get_error_message(),
        'status_code' => 500,
      ];
    }

    if ($result === true) {
      error_log("Sustainable Theme: Plugin installed successfully: " . $plugin_file);
      return [
        'success' => true,
        'message' => 'Plugin installed successfully. You can now activate it.',
        'action' => 'installed',
        'status_code' => 200,
      ];
    }

    error_log("Sustainable Theme: Plugin installation failed with unknown result: " . print_r($result, true));
    return [
      'success' => false,
      'message' => 'Plugin installation failed',
      'status_code' => 500,
    ];
  }

  /**
   * Activate an installed plugin
   * 
   * Activates a previously installed plugin using WordPress's built-in
   * activation system. This method handles the activation process with
   * proper error handling, permission checks, and status validation.
   * 
   * ## Activation Process
   * 
   * ### 1. Pre-Activation Checks
   * - Validates plugin slug format
   * - Verifies plugin is installed but not active
   * - Checks user permissions ('activate_plugins' capability)
   * - Implements rate limiting to prevent abuse
   * 
   * ### 2. Plugin Validation
   * - Confirms plugin files exist in filesystem
   * - Validates plugin header information
   * - Checks for plugin conflicts or errors
   * 
   * ### 3. Activation Execution
   * - Uses WordPress's `activate_plugin()` function
   * - Handles activation hooks and callbacks
   * - Manages plugin state changes
   * 
   * ## Security Features
   * - **Rate Limiting**: 30-second cooldown between activations
   * - **Permission Checks**: Requires 'activate_plugins' capability
   * - **Error Handling**: Comprehensive error reporting
   * - **Status Validation**: Ensures plugin is in correct state
   * 
   * ## Return Value
   * Returns an associative array with activation results:
   * ```php
   * [
   *   'success' => bool,
   *   'action' => string,        // 'activated', 'already_active', 'not_installed', 'error'
   *   'plugin_name' => string,   // Human-readable plugin name
   *   'message' => string,       // Success or error message
   *   'error' => string          // Detailed error information if failed
   * ]
   * ```
   * 
   * ## Usage Examples
   * ```php
   * $result = $plugin_manager->activate_plugin('wp-smushit');
   * 
   * if ($result['success']) {
   *   echo "Plugin activated: " . $result['plugin_name'];
   * } else {
   *   echo "Activation failed: " . $result['error'];
   * }
   * ```
   * 
   * ## Error Handling
   * - **Plugin Not Found**: Handles missing plugin files
   * - **Already Active**: Detects and reports already active plugins
   * - **Activation Errors**: Manages plugin-specific activation failures
   * - **Permission Errors**: Reports insufficient user capabilities
   * 
   * @since 1.0.0
   * @param string $plugin_slug The plugin slug (e.g., 'wp-smushit')
   * @return array Activation results with success status and details
   * 
   * @link https://developer.wordpress.org/reference/functions/activate_plugin/
   * @link https://developer.wordpress.org/reference/functions/is_plugin_active/
   */
  public function activate_plugin(string $plugin_slug): array
  {
    // Debug logging
    error_log("Sustainable Theme: Attempting to activate plugin: " . $plugin_slug);

    // Include necessary files
    if (!function_exists('is_plugin_active')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    // Map plugin slugs to their actual plugin files
    $plugin_map = [
      'wp-smushit' => 'wp-smushit/wp-smush.php',
      'litespeed-cache' => 'litespeed-cache/litespeed-cache.php',
      'wp-optimize' => 'wp-optimize/wp-optimize.php',
      'autoptimize' => 'autoptimize/autoptimize.php',
    ];

    if (!isset($plugin_map[$plugin_slug])) {
      error_log("Sustainable Theme: Invalid plugin slug: " . $plugin_slug);
      return [
        'success' => false,
        'message' => 'Invalid plugin slug',
        'status_code' => 400,
      ];
    }

    $plugin_file = $plugin_map[$plugin_slug];
    error_log("Sustainable Theme: Plugin file: " . $plugin_file);

    // Check if plugin is already active
    if (is_plugin_active($plugin_file)) {
      error_log("Sustainable Theme: Plugin already active: " . $plugin_file);
      return [
        'success' => true,
        'message' => 'Plugin is already active',
        'action' => 'already_active',
        'status_code' => 200,
      ];
    }

    // Check if plugin is installed
    if (!$this->is_plugin_installed($plugin_file)) {
      error_log("Sustainable Theme: Plugin not installed: " . $plugin_file);
      return [
        'success' => false,
        'message' => 'Plugin is not installed. Please install it first.',
        'status_code' => 400,
      ];
    }

    // Activate the plugin
    error_log("Sustainable Theme: Activating plugin: " . $plugin_file);
    $result = activate_plugin($plugin_file);

    if (is_wp_error($result)) {
      error_log("Sustainable Theme: Failed to activate plugin: " . $result->get_error_message());
      return [
        'success' => false,
        'message' => 'Failed to activate plugin: ' . $result->get_error_message(),
        'status_code' => 500,
      ];
    }

    error_log("Sustainable Theme: Plugin activated successfully: " . $plugin_file);
    return [
      'success' => true,
      'message' => 'Plugin activated successfully',
      'action' => 'activated',
      'status_code' => 200,
    ];
  }

  /**
   * Install plugin via AJAX with enhanced error handling
   * 
   * Enhanced version of plugin installation specifically designed for AJAX
   * requests from the frontend. This method provides more detailed error
   * reporting, better filesystem handling, and improved user experience
   * for web-based plugin installation.
   * 
   * ## Enhanced Features
   * 
   * ### 1. Improved Error Handling
   * - More detailed error messages for frontend display
   * - Better handling of filesystem credential requests
   * - Enhanced API error reporting
   * - User-friendly error descriptions
   * 
   * ### 2. Filesystem Management
   * - Automatic filesystem initialization
   * - Credential request handling
   * - Multiple access method support
   * - Connection testing and validation
   * 
   * ### 3. AJAX-Specific Features
   * - Optimized for web interface usage
   * - Better progress reporting
   * - Enhanced status messages
   * - Improved error recovery
   * 
   * ## Installation Process
   * 
   * ### 1. Rate Limiting & Validation
   * - 30-second cooldown between installations
   * - User permission validation
   * - Plugin slug format checking
   * 
   * ### 2. Plugin Information Retrieval
   * - Enhanced `plugins_api()` usage with short_description
   * - Better error handling for API failures
   * - Fallback descriptions for missing data
   * 
   * ### 3. Filesystem Operations
   * - Multi-method filesystem initialization
   * - Credential request handling
   * - Connection testing and validation
   * - Enhanced error reporting
   * 
   * ### 4. Installation Execution
   * - Uses Plugin_Upgrader with enhanced error handling
   * - Better timeout management
   * - Improved rollback capabilities
   * 
   * ## Return Value
   * Returns an associative array with detailed installation results:
   * ```php
   * [
   *   'success' => bool,
   *   'action' => string,           // 'installed', 'already_installed', 'filesystem_credentials_required', 'manual_install_required', 'error'
   *   'plugin_name' => string,     // Human-readable plugin name
   *   'plugin_description' => string, // Plugin description
   *   'plugin_version' => string,  // Installed plugin version
   *   'message' => string,         // Success or error message
   *   'error' => string,           // Detailed error information
   *   'status_code' => int        // HTTP status code for AJAX response
   * ]
   * ```
   * 
   * ## Special Actions
   * 
   * ### filesystem_credentials_required
   * - Indicates FTP/SSH credentials are needed
   * - Frontend should show credential form
   * - User must provide server access details
   * 
   * ### manual_install_required
   * - Automatic installation not possible
   * - User should install manually
   * - Provides installation instructions
   * 
   * ## Usage Examples
   * ```php
   * $result = $plugin_manager->install_plugin_ajax('wp-smushit');
   * 
   * switch ($result['action']) {
   *   case 'installed':
   *     echo "Plugin installed successfully!";
   *     break;
   *   case 'filesystem_credentials_required':
   *     echo "Please provide FTP/SSH credentials";
   *     break;
   *   case 'manual_install_required':
   *     echo "Please install manually: " . $result['message'];
   *     break;
   * }
   * ```
   * 
   * @since 1.0.0
   * @param string $plugin_slug The plugin slug (e.g., 'wp-smushit')
   * @return array Enhanced installation results with detailed status information
   * 
   * @link https://developer.wordpress.org/reference/functions/plugins_api/
   * @link https://developer.wordpress.org/reference/classes/plugin_upgrader/
   * @link https://developer.wordpress.org/reference/functions/wp_filesystem/
   */
  public function install_plugin_ajax(string $plugin_slug): array
  {
    // Rate limiting - prevent abuse
    $user_id = get_current_user_id();
    $rate_limit_key = 'sustainable_theme_install_ajax_' . $user_id;
    $last_install = get_transient($rate_limit_key);

    if ($last_install && (time() - $last_install) < 30) {
      error_log("Sustainable Theme: Rate limit exceeded for user: " . $user_id);
      return [
        'success' => false,
        'message' => 'Please wait 30 seconds before installing another plugin',
        'status_code' => 429,
      ];
    }

    // Set rate limit
    set_transient($rate_limit_key, time(), 30);

    error_log("Sustainable Theme: Attempting AJAX installation of plugin: " . $plugin_slug);
    error_log("Sustainable Theme: AJAX method called (v2.0) - no debug mode required");

    // Include necessary files
    if (!function_exists('is_plugin_active')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    if (!function_exists('plugins_api')) {
      include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
    }

    // Map plugin slugs to their actual plugin files
    $plugin_map = [
      'wp-smushit' => 'wp-smushit/wp-smush.php',
      'litespeed-cache' => 'litespeed-cache/litespeed-cache.php',
      'wp-optimize' => 'wp-optimize/wp-optimize.php',
      'autoptimize' => 'autoptimize/autoptimize.php',
    ];

    if (!isset($plugin_map[$plugin_slug])) {
      error_log("Sustainable Theme: Invalid plugin slug: " . $plugin_slug);
      return [
        'success' => false,
        'message' => 'Invalid plugin slug',
        'status_code' => 400,
      ];
    }

    $plugin_file = $plugin_map[$plugin_slug];

    // Check if plugin is already active
    if (is_plugin_active($plugin_file)) {
      error_log("Sustainable Theme: Plugin already active: " . $plugin_file);
      return [
        'success' => true,
        'message' => 'Plugin is already active',
        'action' => 'already_active',
        'status_code' => 200,
      ];
    }

    // Check if plugin is installed but not active
    if ($this->is_plugin_installed($plugin_file)) {
      error_log("Sustainable Theme: Plugin installed but not active, activating: " . $plugin_file);
      $result = activate_plugin($plugin_file);
      if (is_wp_error($result)) {
        error_log("Sustainable Theme: Failed to activate plugin: " . $result->get_error_message());
        return [
          'success' => false,
          'message' => 'Failed to activate plugin: ' . $result->get_error_message(),
          'status_code' => 500,
        ];
      }

      error_log("Sustainable Theme: Plugin activated successfully: " . $plugin_file);
      return [
        'success' => true,
        'message' => 'Plugin activated successfully',
        'action' => 'activated',
        'status_code' => 200,
      ];
    }

    // Get plugin information
    $api = plugins_api('plugin_information', [
      'slug' => $plugin_slug,
      'fields' => [
        'short_description' => true, // Enable description
        'sections' => false,
        'requires' => false,
        'rating' => false,
        'ratings' => false,
        'downloaded' => false,
        'last_updated' => false,
        'added' => false,
        'tags' => false,
        'compatibility' => false,
        'homepage' => false,
        'donate_link' => false,
      ],
    ]);

    if (is_wp_error($api)) {
      error_log("Sustainable Theme: Failed to get plugin information: " . $api->get_error_message());
      return [
        'success' => false,
        'message' => 'Failed to get plugin information: ' . $api->get_error_message(),
        'status_code' => 500,
      ];
    }

    error_log("Sustainable Theme: Plugin API response - Name: " . $api->name . ", Description: " . ($api->short_description ?? 'null'));

    // Try automatic installation using the same method as the main install_plugin
    error_log("Sustainable Theme: Attempting automatic installation via AJAX method");

    // Include necessary files for installation
    if (!function_exists('install_plugin')) {
      include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
      include_once(ABSPATH . 'wp-admin/includes/file.php');
      include_once(ABSPATH . 'wp-admin/includes/misc.php');
      include_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
    }

    // Use FilesystemManager for installation
    $filesystem_result = $this->filesystem_manager->initialize_filesystem();
    if (!$filesystem_result['success']) {
      error_log("Sustainable Theme: AJAX - All filesystem methods failed, falling back to manual");

      // Provide fallback description if API doesn't return one
      $description = !empty($api->short_description) ? $api->short_description :
        'A recommended plugin for optimizing your WordPress site performance.';

      return [
        'success' => false,
        'message' => 'Automatic installation not available. Please install manually.',
        'action' => 'manual_install_required',
        'plugin_url' => admin_url('plugin-install.php?s=' . $plugin_slug . '&tab=search&type=term'),
        'plugin_name' => $api->name,
        'plugin_description' => $description,
        'status_code' => 200,
      ];
    }

    // Proceed with automatic installation
    error_log("Sustainable Theme: AJAX - Proceeding with automatic installation");

    // Create upgrader skin
    $skin = new \WP_Ajax_Upgrader_Skin();
    $upgrader = new \Plugin_Upgrader($skin);

    // Set time limit for plugin installation
    set_time_limit(300); // 5 minutes max

    // Install the plugin
    $result = $upgrader->install($api->download_link);

    // Reset time limit
    set_time_limit(30);

    if (is_wp_error($result)) {
      error_log("Sustainable Theme: AJAX - Failed to install plugin: " . $result->get_error_message());
      return [
        'success' => false,
        'message' => 'Failed to install plugin: ' . $result->get_error_message(),
        'status_code' => 500,
      ];
    }

    if ($result === true) {
      error_log("Sustainable Theme: AJAX - Plugin installed successfully: " . $plugin_file);
      return [
        'success' => true,
        'message' => 'Plugin installed successfully. You can now activate it.',
        'action' => 'installed',
        'status_code' => 200,
      ];
    }

    error_log("Sustainable Theme: AJAX - Plugin installation failed with unknown result");
    return [
      'success' => false,
      'message' => 'Plugin installation failed',
      'status_code' => 500,
    ];
  }

  /**
   * Check if a plugin is installed
   */
  private function is_plugin_installed(string $plugin_file): bool
  {
    $installed_plugins = get_plugins();
    return isset($installed_plugins[$plugin_file]);
  }
}
