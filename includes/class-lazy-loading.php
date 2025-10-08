<?php

namespace SustainableTheme;

/**
 * Lazy Loading Class
 * 
 * Implements native lazy loading for images with sustainability optimizations
 * 
 * @link https://developer.wordpress.org/reference/functions/wp_img_tag_add_loading_attr/
 * @link https://developer.wordpress.org/reference/functions/get_avatar/
 */
class LazyLoading
{
  /**
   * @var array Theme settings
   */
  private $settings;

  /**
   * Initialize lazy loading functionality
   */
  public function __construct()
  {
    // Get theme settings
    $this->settings = get_option('sustainable_theme_settings', []);

    // Only enable if lazy loading is enabled in settings
    if (!isset($this->settings['enable_lazy_loading']) || $this->settings['enable_lazy_loading']) {
      // Add native lazy loading to all images
      add_filter('wp_img_tag_add_loading_attr', [$this, 'add_loading_attr'], 10, 3);

      // Add lazy loading to avatar images
      add_filter('get_avatar', [$this, 'add_lazy_loading_to_avatar']);

      // Add lazy loading to content images that might be missing the attribute
      add_filter('the_content', [$this, 'add_lazy_loading_to_content_images']);

      // Add lazy loading to ACF images
      add_filter('wp_get_attachment_image_attributes', [$this, 'add_lazy_loading_to_acf_images'], 10, 3);
    }

    // Update settings when they change
    add_action('updated_option', [$this, 'update_settings'], 10, 3);
  }

  /**
   * Add loading attribute to images
   * 
   * @param string $value Current loading attribute
   * @param string $image Image HTML
   * @param string $context Context of the image
   * @return string Modified loading attribute
   */
  public function add_loading_attr(string $value, string $image, string $context): string
  {
    // Don't add lazy loading to images in header or above the fold content
    if ($context === 'header' || $context === 'logo' || $this->is_above_fold()) {
      return 'eager';
    }

    // Otherwise, use lazy loading
    return 'lazy';
  }

  /**
   * Add lazy loading to avatar images
   * 
   * @param string $avatar Avatar HTML
   * @return string Modified avatar HTML
   */
  public function add_lazy_loading_to_avatar(string $avatar): string
  {
    // Skip if already has loading attribute
    if (strpos($avatar, 'loading=') !== false) {
      return $avatar;
    }

    return str_replace('<img', '<img loading="lazy"', $avatar);
  }

  /**
   * Add lazy loading to images in content
   * 
   * @param string $content Post content
   * @return string Modified content
   */
  public function add_lazy_loading_to_content_images(string $content): string
  {
    // Skip if content is empty
    if (empty($content)) {
      return $content;
    }

    // Replace <img> tags with lazy loading attribute if not already present
    return preg_replace_callback('/<img(.*?)(?:\/>|>)/si', function ($matches) {
      // Skip if already has loading attribute
      if (strpos($matches[1], 'loading=') !== false) {
        return $matches[0];
      }

      // Check if it's likely above the fold
      if ($this->is_above_fold()) {
        return str_replace('<img', '<img loading="eager"', $matches[0]);
      }

      // Add lazy loading attribute
      return str_replace('<img', '<img loading="lazy"', $matches[0]);
    }, $content);
  }

  /**
   * Add lazy loading to ACF images
   * 
   * @param array $attr Image attributes
   * @param \WP_Post $attachment Attachment post object
   * @param string|array $size Image size
   * @return array Modified attributes
   */
  public function add_lazy_loading_to_acf_images(array $attr, \WP_Post $attachment, $size): array
  {
    // Set loading attribute if not already set
    if (!isset($attr['loading'])) {
      $attr['loading'] = $this->is_above_fold() ? 'eager' : 'lazy';
    }

    return $attr;
  }

  /**
   * Check if current content is likely above the fold
   * 
   * @return bool True if above fold
   */
  private function is_above_fold(): bool
  {
    // Enhanced above-fold detection
    static $image_count = 0;
    $image_count++;

    // Get above-fold limit from settings, default to 2
    $above_fold_limit = isset($this->settings['above_fold_image_limit'])
      ? (int) $this->settings['above_fold_image_limit']
      : 2;

    // Check if we're in a context where images are likely above fold
    $is_above_fold_context = (
      is_singular() &&
      in_the_loop() &&
      !is_feed() &&
      !is_archive() &&
      !is_search() &&
      $image_count <= $above_fold_limit
    );

    return $is_above_fold_context;
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
