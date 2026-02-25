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
