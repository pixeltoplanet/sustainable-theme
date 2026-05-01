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
define('SUSTAINABLE_THEME_VERSION', '1.0.0');
define('SUSTAINABLE_THEME_DIR', get_template_directory());
define('SUSTAINABLE_THEME_URL', get_template_directory_uri());

include_once get_template_directory() . '/includes/class-admin.php';
include_once get_template_directory() . '/includes/class-settings.php';
include_once get_template_directory() . '/includes/class-sustainability-optimizer.php';
include_once get_template_directory() . '/includes/class-database.php';
include_once get_template_directory() . '/includes/class-lazy-loading.php';
include_once get_template_directory() . '/includes/class-image-sizes.php';
include_once get_template_directory() . '/includes/class-grid-awareness.php';
include_once get_template_directory() . '/includes/class-block-patterns.php';
include_once get_template_directory() . '/includes/class-query-exclude-current.php';
include_once get_template_directory() . '/includes/class-excerpt-hide-readmore.php';

// Initialize the classes
new SustainableTheme\Settings();
new SustainableTheme\AdminMenu();
new SustainableTheme\SustainabilityOptimizer();
new SustainableTheme\Database();
new SustainableTheme\LazyLoading();
new SustainableTheme\Image_Sizes();
new SustainableTheme\GridAwareness();
new SustainableTheme\BlockPatterns();

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
 * Get URL for a theme placeholder image.
 * Use for patterns that need consistent placeholder images without media library dependencies.
 *
 * @param string $slug Image slug. Maps to: hero → coming-soon-bg-image.webp, square/square-1 → flower-meadow-square.webp
 * @return string Full URL to the image.
 */
function sustainable_theme_placeholder_image(string $slug = 'hero'): string
{
  $images = [
    'hero' => 'coming-soon-bg-image.webp',
    'square' => 'flower-meadow-square.webp',
    'square-1' => 'flower-meadow-square.webp',
  ];
  $filename = $images[$slug] ?? 'coming-soon-bg-image.webp';
  return get_theme_file_uri("assets/images/{$filename}");
}
