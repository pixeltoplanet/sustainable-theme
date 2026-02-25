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
    register_block_pattern_category('sustainable-theme', [
      'label'       => __('Sustainable Theme', 'sustainable-theme'),
      'description' => __('Patterns for the Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/content', [
      'label'       => __('Sustainable Theme / Content', 'sustainable-theme'),
      'description' => __('Content patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/portfolio', [
      'label'       => __('Sustainable Theme / Portfolio', 'sustainable-theme'),
      'description' => __('Portfolio patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/posts', [
      'label'       => __('Sustainable Theme / Posts', 'sustainable-theme'),
      'description' => __('Posts patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/hero', [
      'label'       => __('Sustainable Theme / Hero', 'sustainable-theme'),
      'description' => __('Hero patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/header', [
      'label'       => __('Sustainable Theme / Header', 'sustainable-theme'),
      'description' => __('Header patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/footer', [
      'label'       => __('Sustainable Theme / Footer', 'sustainable-theme'),
      'description' => __('Footer patterns for Sustainable Theme.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/gallery', [
      'label'       => __('Sustainable Theme / Gallery', 'sustainable-theme'),
      'description' => __('Gallery and image layout patterns.', 'sustainable-theme'),
    ]);
    register_block_pattern_category('sustainable-theme/cta', [
      'label'       => __('Sustainable Theme / CTA', 'sustainable-theme'),
      'description' => __('Call to action patterns.', 'sustainable-theme'),
    ]);
  }
}
