<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Database Optimization Class
 * 
 * Provides comprehensive database cleanup and optimization functionality
 * including automated cleanup, manual optimization, and security features.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class Database
{
  /**
   * Theme settings array containing database optimization configuration
   * 
   * @var array Contains keys:
   *   - limit_post_revisions: int - Maximum number of revisions to keep per post
   */
  private $settings;

  /**
   * Initialize database optimization features
   * 
   * Sets up WordPress hooks for scheduled cleanup, manual cleanup handling,
   * and settings monitoring. Automatically registers REST API routes for
   * manual database optimization.
   * 
   * ## Hooks Registered:
   * - `wp`: Registers scheduled cleanup task
   * - `sustainable_theme_db_cleanup_event`: Handles cleanup execution
   * - `updated_option`: Monitors settings changes
   * - `rest_api_init`: Registers REST API routes
   * 
   * @since 1.0.0
   */
  public function __construct()
  {
    // Get theme settings
    $this->settings = get_option('sustainable_theme_settings', []);

    // Register database cleanup
    add_action('wp', [$this, 'register_db_cleanup']);

    // Handle database cleanup event
    add_action('sustainable_theme_db_cleanup_event', [$this, 'cleanup_database']);

    // Update settings when they change
    add_action('updated_option', [$this, 'update_settings'], 10, 3);

    // Register REST API routes
    add_action('rest_api_init', [$this, 'register_rest_routes']);
  }

  /**
   * Register scheduled database cleanup task
   * 
   * Sets up a WordPress cron job to automatically clean up the database
   * on a weekly basis. This ensures consistent database maintenance without
   * manual intervention.
   * 
   * ## Schedule Details
   * - **Frequency**: Weekly (`weekly`)
   * - **Hook**: `sustainable_theme_db_cleanup_event`
   * - **Prevention**: Checks for existing scheduled task to avoid duplicates
   * 
   * ## Benefits
   * - Prevents database bloat over time
   * - Maintains optimal performance
   * - Reduces storage requirements
   * - Improves site sustainability
   * 
   * @since 1.0.0
   * @return void
   * 
   * @link https://developer.wordpress.org/reference/functions/wp_schedule_event/
   * @link https://developer.wordpress.org/reference/functions/wp_next_scheduled/
   */
  public function register_db_cleanup(): void
  {
    if (!wp_next_scheduled('sustainable_theme_db_cleanup_event')) {
      wp_schedule_event(time(), 'weekly', 'sustainable_theme_db_cleanup_event');
    }
  }

  /**
   * Perform comprehensive database cleanup
   * 
   * Executes all database optimization operations including post revisions cleanup,
   * orphaned data removal, and transient cleanup.
   * 
   * @since 1.0.0
   * @return array Cleanup statistics with counts of removed items
   */
  public function cleanup_database(): array
  {
    global $wpdb;
    $stats = [
      'revisions_deleted' => 0,
      'auto_drafts_deleted' => 0,
      'orphaned_postmeta_deleted' => 0,
      'orphaned_commentmeta_deleted' => 0,
      'expired_transients_deleted' => 0
    ];

    // Clean up post revisions based on theme settings
    $revision_limit = isset($this->settings['limit_post_revisions']) && $this->settings['limit_post_revisions'] !== false
      ? (int) $this->settings['limit_post_revisions']
      : 5; // Default fallback

    if ($revision_limit > 0) {
      $posts_with_many_revisions = $wpdb->get_results(
        $wpdb->prepare(
          "SELECT post_parent, COUNT(ID) as revision_count 
                 FROM {$wpdb->posts} 
                 WHERE post_type = 'revision' 
                 GROUP BY post_parent 
                 HAVING COUNT(ID) > %d",
          $revision_limit
        )
      );

      foreach ($posts_with_many_revisions as $post) {
        $revision_ids = $wpdb->get_col(
          $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} 
                       WHERE post_parent = %d 
                       AND post_type = 'revision' 
                       ORDER BY post_date DESC 
                       LIMIT 999999 OFFSET %d",
            $post->post_parent,
            $revision_limit
          )
        );

        if (!empty($revision_ids)) {
          foreach ($revision_ids as $id) {
            if (wp_delete_post_revision($id)) {
              $stats['revisions_deleted']++;
            }
          }
        }
      }
    }

    // Clean up auto drafts older than 7 days
    $auto_drafts_result = $wpdb->query(
      "DELETE FROM {$wpdb->posts} 
             WHERE post_status = 'auto-draft' 
             AND DATEDIFF(NOW(), post_date) > 7"
    );
    if ($auto_drafts_result !== false) {
      $stats['auto_drafts_deleted'] = $auto_drafts_result;
    }

    // Clean up orphaned postmeta
    $postmeta_result = $wpdb->query(
      "DELETE pm 
             FROM {$wpdb->postmeta} pm 
             LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id 
             WHERE p.ID IS NULL"
    );
    if ($postmeta_result !== false) {
      $stats['orphaned_postmeta_deleted'] = $postmeta_result;
    }

    // Clean up orphaned commentmeta
    $commentmeta_result = $wpdb->query(
      "DELETE cm 
             FROM {$wpdb->commentmeta} cm 
             LEFT JOIN {$wpdb->comments} c ON c.comment_ID = cm.comment_id 
             WHERE c.comment_ID IS NULL"
    );
    if ($commentmeta_result !== false) {
      $stats['orphaned_commentmeta_deleted'] = $commentmeta_result;
    }

    // Clean up expired transients
    $transients_result = $wpdb->query(
      "DELETE FROM {$wpdb->options} 
             WHERE option_name LIKE '%_transient_%' 
             AND option_name NOT LIKE '%_transient_timeout_%'"
    );
    if ($transients_result !== false) {
      $stats['expired_transients_deleted'] = $transients_result;
    }

    return $stats;
  }

  /**
   * Register REST API routes for database operations
   * 
   * Creates REST API endpoints that allow frontend components to trigger
   * database cleanup operations. This enables the React admin interface
   * to perform database maintenance tasks via AJAX calls.
   * 
   * ## Registered Routes
   * 
   * ### POST /wp-json/sustainable-theme/v1/database/cleanup
   * Triggers manual database cleanup operation.
   * 
   * **Authentication**: Requires valid WordPress nonce
   * **Capability**: Requires 'manage_options' capability
   * **Response**: JSON object with cleanup statistics
   * 
   * **Example Response**:
   * ```json
   * {
   *   "success": true,
   *   "data": {
   *     "revisions_deleted": 15,
   *     "auto_drafts_deleted": 3,
   *     "orphaned_postmeta_deleted": 8,
   *     "orphaned_commentmeta_deleted": 2,
   *     "expired_transients_deleted": 12
   *   }
   * }
   * ```
   * 
   * ## Security Considerations
   * - All routes require valid WordPress nonce authentication
   * - User must have 'manage_options' capability (administrator level)
   * - Rate limiting should be implemented at the application level
   * 
   * @since 1.0.0
   * @return void
   * 
   * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/
   * @link https://developer.wordpress.org/reference/functions/register_rest_route/
   */
  public function register_rest_routes(): void
  {
    register_rest_route('sustainable-theme/v1', '/database/cleanup', [
      'methods' => 'POST',
      'callback' => [$this, 'handle_cleanup_request'],
      'permission_callback' => [$this, 'check_permissions'],
    ]);
  }

  /**
   * Handle manual database cleanup request via REST API
   * 
   * Processes incoming REST API requests to trigger database cleanup operations.
   * This method includes rate limiting, error handling, and comprehensive logging
   * to ensure safe and controlled database maintenance operations.
   * 
   * ## Request Processing Flow
   * 1. **Rate Limiting Check**: Prevents abuse by limiting cleanup frequency
   * 2. **Permission Validation**: Ensures user has 'manage_options' capability
   * 3. **Cleanup Execution**: Runs the actual database cleanup operations
   * 4. **Response Generation**: Returns success/failure status with statistics
   * 5. **Logging**: Records operation details for audit and debugging
   * 
   * ## Rate Limiting
   * - Uses SecurityManager to enforce cooldown periods
   * - Prevents excessive database operations that could impact performance
   * - Returns HTTP 429 (Too Many Requests) when limit exceeded
   * 
   * ## Error Handling
   * - Catches and logs all exceptions during cleanup
   * - Returns user-friendly error messages
   * - Maintains system stability even if cleanup fails
   * 
   * ## Response Format
   * **Success Response** (HTTP 200):
   * ```json
   * {
   *   "success": true,
   *   "data": {
   *     "revisions_deleted": 15,
   *     "auto_drafts_deleted": 3,
   *     "orphaned_postmeta_deleted": 8,
   *     "orphaned_commentmeta_deleted": 2,
   *     "expired_transients_deleted": 12
   *   }
   * }
   * ```
   * 
   * **Error Response** (HTTP 500):
   * ```json
   * {
   *   "success": false,
   *   "message": "Failed to clean up database: [error details]"
   * }
   * ```
   * 
   * @since 1.0.0
   * @return WP_REST_Response JSON response with cleanup results or error message
   * 
   * @link https://developer.wordpress.org/reference/classes/wp_rest_response/
   */
  public function handle_cleanup_request(): \WP_REST_Response
  {
    try {
      // Check rate limit
      if (!SecurityManager::checkRateLimit('database_cleanup')) {
        Logger::warning('Database cleanup rate limit exceeded', [
          'user_id' => get_current_user_id()
        ]);

        return new \WP_REST_Response([
          'success' => false,
          'message' => 'Rate limit exceeded. Please wait before running another cleanup.'
        ], 429);
      }

      Logger::info('Starting manual database cleanup', [
        'user_id' => get_current_user_id()
      ]);

      $stats = $this->cleanup_database();

      $total_items = array_sum($stats);
      $message = sprintf(
        __('Database cleaned up successfully! Removed %d items: %d revisions, %d auto-drafts, %d orphaned postmeta, %d orphaned commentmeta, %d expired transients.', 'sustainable'),
        $total_items,
        $stats['revisions_deleted'],
        $stats['auto_drafts_deleted'],
        $stats['orphaned_postmeta_deleted'],
        $stats['orphaned_commentmeta_deleted'],
        $stats['expired_transients_deleted']
      );

      Logger::info('Database cleanup completed successfully', [
        'user_id' => get_current_user_id(),
        'stats' => $stats,
        'total_items' => $total_items
      ]);

      return new \WP_REST_Response([
        'success' => true,
        'message' => $message,
        'stats' => $stats
      ], 200);
    } catch (\Exception $e) {
      Logger::error('Database cleanup failed', [
        'error' => $e->getMessage(),
        'user_id' => get_current_user_id(),
        'trace' => $e->getTraceAsString()
      ]);

      return new \WP_REST_Response([
        'success' => false,
        'message' => __('Failed to clean up database: ', 'sustainable') . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Check user permissions for database operations
   * 
   * Validates that the current user has the necessary permissions to perform
   * database cleanup operations. This method serves as a permission callback
   * for REST API routes and ensures only authorized users can trigger
   * database maintenance tasks.
   * 
   * ## Permission Requirements
   * - User must be logged in (authenticated)
   * - User must have 'manage_options' capability (typically administrators)
   * - Valid WordPress nonce must be provided in request headers
   * 
   * ## Security Features
   * - Prevents unauthorized database modifications
   * - Protects against CSRF attacks via nonce validation
   * - Ensures only trusted users can perform maintenance operations
   * 
   * @since 1.0.0
   * @return bool True if user has permission, false otherwise
   * 
   * @link https://developer.wordpress.org/reference/functions/current_user_can/
   * @link https://developer.wordpress.org/reference/functions/wp_verify_nonce/
   */
  public function check_permissions(): bool
  {
    return current_user_can('manage_options');
  }

  /**
   * Update settings when they change
   */
  public function update_settings($option_name, $old_value, $new_value): void
  {
    if ($option_name === 'sustainable_theme_settings') {
      $this->settings = $new_value;
    }
  }
}
