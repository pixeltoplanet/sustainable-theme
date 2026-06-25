<?php

namespace SustainableTheme;

/**
 * Registers block pattern categories. Patterns in the theme's /patterns folder
 * are automatically registered by WordPress; this class only registers the
 * custom categories those patterns use.
 */
class BlockPatterns
{
  public function __construct()
  {
    add_action('init', [$this, 'register_block_pattern_categories']);
    // Clear pattern file cache so new files in /patterns are discovered (WordPress caches the list).
    add_action('init', [$this, 'maybe_clear_pattern_cache'], 5);
    // Disable WordPress core and remote (Pattern Directory) patterns so only theme patterns are offered.
    add_action('after_setup_theme', [$this, 'disable_core_patterns']);
    add_filter('should_load_remote_block_patterns', '__return_false');
  }

  /**
   * Remove core block patterns bundled with WordPress. The theme provides its
   * own curated patterns in /patterns and does not rely on core defaults.
   */
  public function disable_core_patterns(): void
  {
    remove_theme_support('core-block-patterns');
  }

  /**
   * Clear theme pattern cache when in development so new pattern files appear without switching themes.
   */
  public function maybe_clear_pattern_cache(): void
  {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
      return;
    }
    $theme = wp_get_theme();
    if ($theme->exists()) {
      $theme->delete_pattern_cache();
    }
  }

  /**
   * Register custom block pattern categories for the theme.
   */
  public function register_block_pattern_categories(): void
  {
    register_block_pattern_category('sustainable-theme/pages', [
      'label'       => __('Pages', 'sustainable-theme'),
      'description' => __('Full-page patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/content', [
      'label'       => __('Content', 'sustainable-theme'),
      'description' => __('Content patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/portfolio', [
      'label'       => __('Portfolio', 'sustainable-theme'),
      'description' => __('Portfolio patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/posts', [
      'label'       => __('Posts', 'sustainable-theme'),
      'description' => __('Posts patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/hero', [
      'label'       => __('Hero', 'sustainable-theme'),
      'description' => __('Hero patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/header', [
      'label'       => __('Header', 'sustainable-theme'),
      'description' => __('Header patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/footer', [
      'label'       => __('Footer', 'sustainable-theme'),
      'description' => __('Footer patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/gallery', [
      'label'       => __('Gallery', 'sustainable-theme'),
      'description' => __('Gallery and image layout patterns.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/cta', [
      'label'       => __('CTA', 'sustainable-theme'),
      'description' => __('Call to action patterns.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/services', [
      'label'       => __('Services & features', 'sustainable-theme'),
      'description' => __('Services and features patterns.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/single-post', [
      'label'       => __('Single post', 'sustainable-theme'),
      'description' => __('Single post patterns.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/contact', [
      'label'       => __('Contact', 'sustainable-theme'),
      'description' => __('Contact and form patterns.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/new', [
      'label'       => __('NEW', 'sustainable-theme'),
      'description' => __('New patterns pending review and testing.', 'sustainable-theme'),
    ]);
  }
}
