<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Database Optimization Class
 * 
 * Handles database cleanup and query optimization for the Sustainable Theme
 */
class Database
{
  private $settings;

  /**
   * Initialize the database optimization features
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
   * Register a scheduled task to clean up database
   */
  public function register_db_cleanup(): void
  {
    if (!wp_next_scheduled('sustainable_theme_db_cleanup_event')) {
      wp_schedule_event(time(), 'weekly', 'sustainable_theme_db_cleanup_event');
    }
  }

  /**
   * Clean up database tables by removing unnecessary data
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
   * Register REST API routes
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
   * Handle manual cleanup request via REST API
   */
  public function handle_cleanup_request(): \WP_REST_Response
  {
    try {
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

      return new \WP_REST_Response([
        'success' => true,
        'message' => $message,
        'stats' => $stats
      ], 200);
    } catch (\Exception $e) {
      return new \WP_REST_Response([
        'success' => false,
        'message' => __('Failed to clean up database: ', 'sustainable') . $e->getMessage()
      ], 500);
    }
  }

  /**
   * Check permissions for REST API
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
