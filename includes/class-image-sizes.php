<?php

namespace SustainableTheme;

defined('ABSPATH') || exit('Forbidden');

/**
 * Image Sizes Class
 * 
 * Manages responsive image sizes for sustainability and performance
 * 
 * @link https://developer.wordpress.org/reference/functions/add_image_size/
 * @link https://developer.wordpress.org/reference/functions/remove_image_size/
 */
class Image_Sizes
{
  /**
   * @var array Theme settings
   */
  private $settings;

  /**
   * Size definitions keyed by category name
   */
  public static $size_definitions = [
    'small' => [
      'sizes' => ['sustainable_theme_375', 'sustainable_theme_480'],
      'max_size' => 'sustainable_theme_480'
    ],
    'medium' => [
      'sizes' => ['sustainable_theme_375', 'sustainable_theme_480', 'sustainable_theme_768'],
      'max_size' => 'sustainable_theme_768'
    ],
    'large' => [
      'sizes' => ['sustainable_theme_375', 'sustainable_theme_480', 'sustainable_theme_768', 'sustainable_theme_1024', 'sustainable_theme_1400'],
      'max_size' => 'sustainable_theme_1400'
    ],
    'full' => [
      'sizes' => ['sustainable_theme_375', 'sustainable_theme_480', 'sustainable_theme_768', 'sustainable_theme_1024', 'sustainable_theme_1400', 'sustainable_theme_1920'],
      'max_size' => 'sustainable_theme_1920'
    ]
  ];

  public function __construct()
  {
    // Get theme settings
    $this->settings = get_option('sustainable_theme_settings', []);

    // Only enable if image optimization is enabled in settings
    if (!isset($this->settings['enable_image_optimization']) || $this->settings['enable_image_optimization']) {
      add_action('after_setup_theme', array($this, 'setup'));
    }

    // Update settings when they change
    add_action('updated_option', [$this, 'update_settings'], 10, 3);
  }

  /**
   * Setup image sizes
   */
  public function setup()
  {
    $this->add_image_sizes();

    // Only remove default sizes if setting is enabled
    if (isset($this->settings['remove_default_image_sizes']) && $this->settings['remove_default_image_sizes']) {
      $this->remove_default_image_sizes();
    }
  }

  /**
   * Get sizes for a category
   *
   * @param string $category Size category ('small', 'medium', 'large', 'full')
   * @return array Array of size names for the category
   */
  public static function get_sizes(string $category = 'medium'): array
  {
    // Default to medium if category not found
    if (!isset(self::$size_definitions[$category])) {
      $category = 'medium';
    }

    return self::$size_definitions[$category]['sizes'];
  }

  /**
   * Get the max size for a category
   *
   * @param string $category Size category ('small', 'medium', 'large', 'full')
   * @return string The maximum size name for this category
   */
  public static function get_max_size(string $category = 'medium'): string
  {
    // Default to medium if category not found
    if (!isset(self::$size_definitions[$category])) {
      $category = 'medium';
    }

    return self::$size_definitions[$category]['max_size'];
  }

  /**
   * Add optimized image sizes
   */
  public function add_image_sizes()
  {
    // Get size limit from settings, default to 'large' for sustainability
    $size_limit = isset($this->settings['max_image_size'])
      ? $this->settings['max_image_size']
      : 'large';

    // Always add the essential sizes
    add_image_size('sustainable_theme_480', 480, 9999);
    add_image_size('sustainable_theme_768', 768, 9999);
    add_image_size('sustainable_theme_1024', 1024, 9999);

    // Add larger sizes based on settings
    if ($size_limit === 'medium') {
      // Medium optimization - stop at 1024px
      // No additional sizes needed
    } elseif ($size_limit === 'large') {
      // Large optimization - add 1400px
      add_image_size('sustainable_theme_1400', 1400, 9999);
    } elseif ($size_limit === 'full') {
      // Full optimization - add all sizes
      add_image_size('sustainable_theme_1400', 1400, 9999);
      add_image_size('sustainable_theme_1920', 1920, 720, true);
    }

    // Add mobile-first sizes
    add_image_size('sustainable_theme_375', 375, 9999);
  }

  /**
   * Remove default image sizes for sustainability
   */
  public function remove_default_image_sizes()
  {
    remove_image_size('medium');
    remove_image_size('large');
    remove_image_size('full');
  }

  /**
   * Update settings when they change
   * 
   * @param string $option_name Option name
   * @param mixed $old_value Old value
   * @param mixed $new_value New value
   */
  public function update_settings(string $option_name, $old_value, $new_value): void
  {
    if ($option_name === 'sustainable_theme_settings') {
      $this->settings = $new_value;
    }
  }
}
