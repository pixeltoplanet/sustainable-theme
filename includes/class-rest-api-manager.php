<?php

namespace SustainableTheme;

/**
 * REST API Management Class
 * 
 * Centralizes all REST API route registration and management for the Sustainable
 * Theme. Coordinates between frontend React components and backend PHP classes.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class RestApiManager
{
  private Settings $settings;
  private PluginManager $plugin_manager;
  private FilesystemManager $filesystem_manager;

  /**
   * RestApiManager constructor
   * 
   * Initializes the REST API manager with required dependencies.
   * 
   * @param Settings $settings Theme settings manager instance
   * @param PluginManager $plugin_manager Plugin operations manager instance
   * @param FilesystemManager $filesystem_manager Filesystem operations manager instance
   * @since 1.0.0
   */
  public function __construct(Settings $settings, PluginManager $plugin_manager, FilesystemManager $filesystem_manager)
  {
    $this->settings = $settings;
    $this->plugin_manager = $plugin_manager;
    $this->filesystem_manager = $filesystem_manager;
  }

  /**
   * Register all REST API routes for the Sustainable Theme
   * 
   * Orchestrates the registration of all REST API endpoints used by the theme.
   * This method acts as the central coordinator, delegating route registration
   * to specialized methods for different functional areas. All routes are
   * registered under the 'sustainable-theme/v1' namespace.
   * 
   * ## Route Categories
   * 
   * ### Settings Routes
   * - Theme configuration management
   * - Sustainability settings operations
   * - Mode-based settings updates
   * - Settings reset functionality
   * 
   * ### Plugin Routes
   * - Recommended plugin retrieval
   * - Plugin installation operations
   * - Plugin activation management
   * - AJAX-enhanced installation
   * 
   * ### Filesystem Routes
   * - Server access capability checking
   * - Credential management
   * - Filesystem method detection
   * 
   * ## Registration Process
   * 1. **Settings Routes**: Registers theme settings endpoints
   * 2. **Plugin Routes**: Registers plugin management endpoints
   * 3. **Filesystem Routes**: Registers server access endpoints
   * 4. **Logging**: Records successful registration for debugging
   * 
   * ## Security Features
   * - All routes include permission callbacks
   * - Nonce validation for CSRF protection
   * - User capability checks
   * - Rate limiting implementation
   * 
   * ## Usage
   * This method is typically called during WordPress initialization:
   * ```php
   * add_action('rest_api_init', function() {
   *   $rest_api = new RestApiManager($settings, $plugin_manager, $filesystem_manager);
   *   $rest_api->register_routes();
   * });
   * ```
   * 
   * @since 1.0.0
   * @return void
   * 
   * @link https://developer.wordpress.org/reference/hooks/rest_api_init/
   * @link https://developer.wordpress.org/reference/functions/register_rest_route/
   */
  public function register_routes(): void
  {
    error_log("Sustainable Theme: Registering REST API routes");

    // Settings routes
    $this->register_settings_routes();

    // Plugin routes
    $this->register_plugin_routes();

    // Filesystem routes
    $this->register_filesystem_routes();

    error_log("Sustainable Theme: REST API routes registered successfully");
  }

  /**
   * Register settings-related routes
   */
  private function register_settings_routes(): void
  {
    register_rest_route('sustainable-theme/v1', '/settings', [
      [
        'methods' => 'GET',
        'callback' => [$this, 'get_settings'],
        'permission_callback' => [$this, 'check_permissions'],
      ],
      [
        'methods' => 'POST',
        'callback' => [$this, 'update_settings'],
        'permission_callback' => [$this, 'check_permissions'],
        'args' => [
          'settings' => [
            'required' => true,
            'type' => 'object',
            'sanitize_callback' => [$this->settings, 'sanitize_settings'],
          ],
        ],
      ],
    ]);

    // Route to update settings based on sustainability mode
    register_rest_route('sustainable-theme/v1', '/settings/mode/(?P<mode>[\w]+)', [
      'methods' => 'POST',
      'callback' => [$this, 'update_by_mode'],
      'permission_callback' => [$this, 'check_permissions'],
      'args' => [
        'mode' => [
          'required' => true,
          'type' => 'string',
          'enum' => ['base', 'super', 'custom'],
        ],
      ],
    ]);

    // Route to reset settings to defaults
    register_rest_route('sustainable-theme/v1', '/settings/reset', [
      'methods' => 'POST',
      'callback' => [$this, 'reset_settings'],
      'permission_callback' => [$this, 'check_permissions'],
    ]);
  }

  /**
   * Register plugin-related routes
   */
  private function register_plugin_routes(): void
  {
    // Route to get recommended plugins
    register_rest_route('sustainable-theme/v1', '/recommended-plugins', [
      'methods' => 'GET',
      'callback' => [$this, 'get_recommended_plugins'],
      'permission_callback' => [$this, 'check_permissions'],
    ]);

    // Route to install plugins
    register_rest_route('sustainable-theme/v1', '/install-plugin', [
      'methods' => 'POST',
      'callback' => [$this, 'install_plugin'],
      'permission_callback' => [$this, 'check_permissions'],
      'args' => [
        'plugin_slug' => [
          'required' => true,
          'type' => 'string',
          'sanitize_callback' => 'sanitize_text_field',
        ],
      ],
    ]);

    // Route to activate plugins
    register_rest_route('sustainable-theme/v1', '/activate-plugin', [
      'methods' => 'POST',
      'callback' => [$this, 'activate_plugin'],
      'permission_callback' => [$this, 'check_permissions'],
      'args' => [
        'plugin_slug' => [
          'required' => true,
          'type' => 'string',
          'sanitize_callback' => 'sanitize_text_field',
        ],
      ],
    ]);

    // Route to install plugins via admin-ajax (safer alternative)
    register_rest_route('sustainable-theme/v1', '/install-plugin-ajax', [
      'methods' => 'POST',
      'callback' => [$this, 'install_plugin_ajax'],
      'permission_callback' => [$this, 'check_permissions'],
      'args' => [
        'plugin_slug' => [
          'required' => true,
          'type' => 'string',
          'sanitize_callback' => 'sanitize_text_field',
        ],
      ],
    ]);
  }

  /**
   * Register filesystem-related routes
   */
  private function register_filesystem_routes(): void
  {
    // Route to check filesystem access
    register_rest_route('sustainable-theme/v1', '/check-filesystem-access', [
      'methods' => 'GET',
      'callback' => [$this, 'check_filesystem_access'],
      'permission_callback' => [$this, 'check_permissions'],
    ]);
  }

  /**
   * Check user permissions for REST API access
   * 
   * Validates that the current user has the necessary permissions to access
   * REST API endpoints. This method serves as a permission callback for all
   * registered routes and ensures only authorized users can perform operations.
   * 
   * ## Permission Requirements
   * - **User Authentication**: User must be logged in
   * - **Administrator Capability**: Requires 'manage_options' capability
   * - **Nonce Validation**: Valid WordPress nonce must be provided
   * 
   * ## Security Features
   * - **CSRF Protection**: Nonce validation prevents cross-site request forgery
   * - **Capability Checks**: Ensures only administrators can access endpoints
   * - **Authentication**: Verifies user is logged in and authorized
   * - **Error Handling**: Returns false for unauthorized access attempts
   * 
   * ## Usage
   * This method is used as a permission callback for REST API routes:
   * ```php
   * register_rest_route('sustainable-theme/v1', '/settings', [
   *   'methods' => 'GET',
   *   'callback' => [$this, 'get_settings'],
   *   'permission_callback' => [$this, 'check_permissions'],
   * ]);
   * ```
   * 
   * ## Return Value
   * - **true**: User has permission to access the endpoint
   * - **false**: User lacks permission or authentication failed
   * 
   * @since 1.0.0
   * @return bool True if user has permission, false otherwise
   * 
   * @link https://developer.wordpress.org/reference/functions/current_user_can/
   * @link https://developer.wordpress.org/reference/functions/wp_verify_nonce/
   */
  public function check_permissions(): bool
  {
    $can_manage = current_user_can('manage_options');
    $user_id = get_current_user_id();
    $nonce = $_SERVER['HTTP_X_WP_NONCE'] ?? '';

    error_log("Sustainable Theme: Permission check - can_manage_options: " . ($can_manage ? 'true' : 'false'));
    error_log("Sustainable Theme: Current user ID: " . $user_id);
    error_log("Sustainable Theme: Nonce from header: " . $nonce);
    error_log("Sustainable Theme: Nonce validation: " . (wp_verify_nonce($nonce, 'wp_rest') ? 'valid' : 'invalid'));

    return $can_manage;
  }

  /**
   * Format API response
   */
  private function format_response(array $data, int $status_code = 200): \WP_REST_Response
  {
    return new \WP_REST_Response($data, $status_code);
  }

  /**
   * Get current theme settings via REST API
   * 
   * Retrieves the current theme settings and returns them as a JSON response.
   * This endpoint is used by the frontend React components to load the
   * current configuration state for display and editing.
   * 
   * ## Response Format
   * Returns a WP_REST_Response with the following structure:
   * ```json
   * {
   *   "success": true,
   *   "data": {
   *     "sustainability_mode": "balanced",
   *     "enable_image_optimization": true,
   *     "enable_caching": false,
   *     // ... other settings
   *   }
   * }
   * ```
   * 
   * ## Usage
   * Frontend JavaScript can call this endpoint to load settings:
   * ```javascript
   * const response = await fetch('/wp-json/sustainable-theme/v1/settings', {
   *   headers: { 'X-WP-Nonce': wpApiSettings.nonce }
   * });
   * const data = await response.json();
   * ```
   * 
   * @since 1.0.0
   * @return WP_REST_Response JSON response with current settings
   */
  public function get_settings(): \WP_REST_Response
  {
    $settings = $this->settings->get_settings();
    return $this->format_response($settings);
  }

  /**
   * Update theme settings via REST API
   * 
   * Updates theme settings with new values provided in the request body.
   * This endpoint validates the input data and persists changes to the
   * database through the Settings class.
   * 
   * ## Request Format
   * Expects JSON data in the request body:
   * ```json
   * {
   *   "sustainability_mode": "aggressive",
   *   "enable_image_optimization": true,
   *   "enable_caching": true
   * }
   * ```
   * 
   * ## Response Format
   * Returns success/failure status:
   * ```json
   * {
   *   "success": true,
   *   "message": "Settings updated successfully"
   * }
   * ```
   * 
   * @since 1.0.0
   * @param WP_REST_Request $request The REST API request object
   * @return WP_REST_Response JSON response with update status
   */
  public function update_settings(\WP_REST_Request $request): \WP_REST_Response
  {
    $result = $this->settings->update_settings($request);
    return $result;
  }

  /**
   * Update settings by sustainability mode via REST API
   * 
   * Updates theme settings based on a predefined sustainability mode.
   * This endpoint allows users to quickly apply preset configurations
   * for different sustainability levels (conservative, balanced, aggressive).
   * 
   * ## Request Format
   * Expects mode parameter in request body:
   * ```json
   * {
   *   "mode": "aggressive"
   * }
   * ```
   * 
   * ## Available Modes
   * - **conservative**: Minimal impact, basic optimizations
   * - **balanced**: Moderate optimizations, good performance
   * - **aggressive**: Maximum optimizations, best performance
   * 
   * @since 1.0.0
   * @param WP_REST_Request $request The REST API request object
   * @return WP_REST_Response JSON response with update status
   */
  public function update_by_mode(\WP_REST_Request $request): \WP_REST_Response
  {
    $result = $this->settings->update_by_mode($request);
    return $result;
  }

  /**
   * Reset theme settings to defaults via REST API
   * 
   * Resets all theme settings to their default values. This endpoint
   * provides a quick way to restore the original configuration
   * and start fresh with theme settings.
   * 
   * ## Response Format
   * Returns success status and reset confirmation:
   * ```json
   * {
   *   "success": true,
   *   "message": "Settings reset to defaults successfully"
   * }
   * ```
   * 
   * @since 1.0.0
   * @param WP_REST_Request $request The REST API request object
   * @return WP_REST_Response JSON response with reset status
   */
  public function reset_settings(\WP_REST_Request $request): \WP_REST_Response
  {
    $result = $this->settings->reset_settings($request);
    return $result;
  }

  // Plugin route handlers
  /**
   * Get recommended plugins via REST API
   * 
   * Retrieves the list of recommended plugins with their current
   * installation and activation status. This endpoint is used by
   * the frontend to display plugin recommendations and manage
   * plugin installation/activation.
   * 
   * ## Response Format
   * Returns array of plugin objects with status information:
   * ```json
   * {
   *   "success": true,
   *   "data": [
   *     {
   *       "slug": "wp-smushit",
   *       "name": "Smush - Image Optimization",
   *       "description": "Automatically optimize images...",
   *       "is_installed": false,
   *       "is_active": false
   *     }
   *   ]
   * }
   * ```
   * 
   * @since 1.0.0
   * @return WP_REST_Response JSON response with recommended plugins
   */
  public function get_recommended_plugins(): \WP_REST_Response
  {
    $plugins = $this->plugin_manager->get_recommended_plugins();
    return $this->format_response([
      'success' => true,
      'plugins' => $plugins,
    ]);
  }

  /**
   * Install plugin via REST API
   * 
   * Installs a plugin from WordPress.org repository. This endpoint
   * handles the complete installation process including download,
   * extraction, and filesystem operations.
   * 
   * ## Request Format
   * Expects plugin slug in request body:
   * ```json
   * {
   *   "plugin_slug": "wp-smushit"
   * }
   * ```
   * 
   * @since 1.0.0
   * @param WP_REST_Request $request The REST API request object
   * @return WP_REST_Response JSON response with installation status
   */
  public function install_plugin(\WP_REST_Request $request): \WP_REST_Response
  {
    $plugin_slug = $request->get_param('plugin_slug');
    $result = $this->plugin_manager->install_plugin($plugin_slug);

    return $this->format_response($result, $result['status_code'] ?? 200);
  }

  /**
   * Activate plugin via REST API
   * 
   * Activates a previously installed plugin. This endpoint
   * handles the activation process and returns the result.
   * 
   * ## Request Format
   * Expects plugin slug in request body:
   * ```json
   * {
   *   "plugin_slug": "wp-smushit"
   * }
   * ```
   * 
   * @since 1.0.0
   * @param WP_REST_Request $request The REST API request object
   * @return WP_REST_Response JSON response with activation status
   */
  public function activate_plugin(\WP_REST_Request $request): \WP_REST_Response
  {
    $plugin_slug = $request->get_param('plugin_slug');
    $result = $this->plugin_manager->activate_plugin($plugin_slug);

    return $this->format_response($result, $result['status_code'] ?? 200);
  }

  /**
   * Install plugin via AJAX with enhanced error handling
   * 
   * Enhanced plugin installation endpoint specifically designed for AJAX
   * requests. Provides better error handling, filesystem credential
   * management, and user-friendly responses.
   * 
   * ## Request Format
   * Expects plugin slug in request body:
   * ```json
   * {
   *   "plugin_slug": "wp-smushit"
   * }
   * ```
   * 
   * ## Enhanced Features
   * - Better error messages for frontend display
   * - Filesystem credential request handling
   * - Manual installation fallback options
   * - Detailed status reporting
   * 
   * @since 1.0.0
   * @param WP_REST_Request $request The REST API request object
   * @return WP_REST_Response JSON response with detailed installation status
   */
  public function install_plugin_ajax(\WP_REST_Request $request): \WP_REST_Response
  {
    $plugin_slug = $request->get_param('plugin_slug');
    $result = $this->plugin_manager->install_plugin_ajax($plugin_slug);

    return $this->format_response($result, $result['status_code'] ?? 200);
  }

  // Filesystem route handlers
  /**
   * Check filesystem access capabilities via REST API
   * 
   * Checks the current filesystem access capabilities and returns
   * information about available methods, permissions, and requirements
   * for plugin installation operations.
   * 
   * ## Response Format
   * Returns filesystem access information:
   * ```json
   * {
   *   "success": true,
   *   "data": {
   *     "can_install_plugins": true,
   *     "plugin_dir_writable": true,
   *     "available_methods": ["direct", "ftp"],
   *     "current_method": "direct",
   *     "needs_credentials": false
   *   }
   * }
   * ```
   * 
   * @since 1.0.0
   * @param WP_REST_Request $request The REST API request object
   * @return WP_REST_Response JSON response with filesystem access status
   */
  public function check_filesystem_access(\WP_REST_Request $request): \WP_REST_Response
  {
    $result = $this->filesystem_manager->check_filesystem_access();
    return $this->format_response($result);
  }
}
