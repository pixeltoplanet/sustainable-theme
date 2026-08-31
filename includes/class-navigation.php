<?php

namespace SustainableTheme;

/**
 * Creates and maintains the theme's central "Main Menu".
 *
 * Block themes store menus as wp_navigation posts. Shipping a single shared
 * menu (rather than links duplicated inline in each pattern) means editing it
 * once in the Site Editor updates every header and footer that references it.
 * The menu is seeded on theme activation and referenced by ID from the
 * navigation patterns via sustainable_theme_navigation().
 */
class Navigation
{
  private const MENU_SLUG  = 'main-menu';
  private const MENU_TITLE = 'Main Menu';

  public function __construct()
  {
    add_action('after_switch_theme', [$this, 'create_main_menu']);
  }

  /**
   * Ensure the Main Menu navigation post exists on theme activation.
   */
  public function create_main_menu(): void
  {
    self::get_main_menu_id();
  }

  /**
   * Get the ID of the central Main Menu navigation post, creating it on demand.
   *
   * Creating on demand (in addition to activation) self-heals if the post is
   * ever deleted, so the navigation patterns always resolve to a real menu.
   *
   * @return int Post ID, or 0 if it could not be created.
   */
  public static function get_main_menu_id(): int
  {
    static $cached = null;
    if ($cached !== null) {
      return $cached;
    }

    $existing = get_posts([
      'post_type'              => 'wp_navigation',
      'name'                   => self::MENU_SLUG,
      'post_status'            => 'publish',
      'posts_per_page'         => 1,
      'no_found_rows'          => true,
      'update_post_meta_cache' => false,
      'update_post_term_cache' => false,
    ]);

    if (!empty($existing)) {
      return $cached = (int) $existing[0]->ID;
    }

    $post_id = wp_insert_post([
      'post_type'    => 'wp_navigation',
      'post_title'   => self::MENU_TITLE,
      'post_name'    => self::MENU_SLUG,
      'post_status'  => 'publish',
      'post_content' => sustainable_theme_default_navigation_links(),
    ]);

    return $cached = (is_wp_error($post_id) || !$post_id) ? 0 : (int) $post_id;
  }
}
