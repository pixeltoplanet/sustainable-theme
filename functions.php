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
define('SUSTAINABLE_THEME_VERSION', '0.1.0');
define('SUSTAINABLE_THEME_DIR', get_template_directory());
define('SUSTAINABLE_THEME_URL', get_template_directory_uri());

include_once get_template_directory() . '/includes/class-admin.php';
include_once get_template_directory() . '/includes/class-settings.php';
include_once get_template_directory() . '/includes/class-plugin-manager.php';
include_once get_template_directory() . '/includes/class-filesystem-manager.php';
include_once get_template_directory() . '/includes/class-rest-api-manager.php';
include_once get_template_directory() . '/includes/class-sustainability-optimizer.php';
include_once get_template_directory() . '/includes/class-database.php';
include_once get_template_directory() . '/includes/class-lazy-loading.php';
include_once get_template_directory() . '/includes/class-image-sizes.php';
include_once get_template_directory() . '/includes/class-grid-awareness.php';
include_once get_template_directory() . '/includes/class-logger.php';
include_once get_template_directory() . '/includes/class-settings-validator.php';
include_once get_template_directory() . '/includes/class-security-manager.php';
include_once get_template_directory() . '/includes/class-sustainability-tester.php';

// Initialize the classes
new SustainableTheme\Settings();
new SustainableTheme\AdminMenu();
new SustainableTheme\SustainabilityOptimizer();
new SustainableTheme\Database();
new SustainableTheme\LazyLoading();
new SustainableTheme\Image_Sizes();
new SustainableTheme\GridAwareness();
new SustainableTheme\SecurityManager();

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
// add_action('wp_enqueue_scripts', 'sustainable_theme_enqueue_frontend_styles');

/**
 * Limit file upload size to 1MB
 * 
 * Reduces server storage and bandwidth usage for sustainability.
 * This applies to all file uploads in WordPress media library.
 * 
 * Note: This modifies PHP settings if allowed. If PHP restrictions prevent
 * this, files larger than 1MB will be rejected during upload validation.
 */
function sustainable_theme_limit_upload_size()
{
  // Set maximum upload size to 1MB (1048576 bytes)
  $max_size = 1048576; // 1MB

  // Try to modify PHP upload settings (may not work if PHP is restricted)
  @ini_set('upload_max_filesize', '1M');
  @ini_set('post_max_size', '1M');
}
add_action('init', 'sustainable_theme_limit_upload_size');

/**
 * Validate file upload size before processing
 * 
 * Rejects files larger than 1MB even if PHP settings allow larger uploads.
 * 
 * @param array $file Uploaded file data
 * @return array Modified file data or error
 */
function sustainable_theme_validate_upload_size($file)
{
  $max_size = 1048576; // 1MB

  if (isset($file['size']) && $file['size'] > $max_size) {
    $file['error'] = sprintf(
      __('File is too large. Maximum upload size is %s.', 'sustainable-theme'),
      size_format($max_size)
    );
  }

  return $file;
}
add_filter('wp_handle_upload_prefilter', 'sustainable_theme_validate_upload_size');

// print_r($_SERVER['SERVER_SOFTWARE']);
