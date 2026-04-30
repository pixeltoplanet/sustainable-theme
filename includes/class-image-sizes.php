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

  public const BLURRED_SUFFIX = '-blurred';
  public const BLURRED_WIDTH  = 480;
  public const BLUR_RADIUS    = 10;
  public const BLUR_QUALITY   = 30;

  public function __construct()
  {
    // Get theme settings
    $this->settings = get_option('sustainable_theme_settings', []);

    // Only enable if image optimization is enabled in settings
    if (!isset($this->settings['enable_image_optimization']) || $this->settings['enable_image_optimization']) {
      add_action('after_setup_theme', array($this, 'setup'));
    }

    // Generate blurred variant on upload when blurred mode is active
    add_filter('wp_generate_attachment_metadata', [$this, 'generate_blurred_variant'], 10, 2);

    // REST route for bulk blur generation
    add_action('rest_api_init', [$this, 'register_rest_routes']);

    // Update settings when they change
    add_action('updated_option', [$this, 'update_settings'], 10, 3);
  }

  /**
   * Register REST API routes for image operations
   */
  public function register_rest_routes(): void
  {
    register_rest_route('sustainable-theme/v1', '/images/generate-blurred', [
      'methods'             => 'POST',
      'callback'            => [$this, 'rest_generate_blurred'],
      'permission_callback' => function () {
        return current_user_can('manage_options');
      },
    ]);
  }

  /**
   * REST callback: generate missing blurred variants in a single batch.
   */
  public function rest_generate_blurred(\WP_REST_Request $request): \WP_REST_Response
  {
    @set_time_limit(300);

    $attachments = get_posts([
      'post_type'      => 'attachment',
      'post_mime_type' => ['image/jpeg', 'image/png', 'image/webp'],
      'post_status'    => 'inherit',
      'posts_per_page' => -1,
      'fields'         => 'ids',
    ]);

    $total     = count($attachments);
    $generated = 0;
    $skipped   = 0;
    $failed    = 0;

    foreach ($attachments as $id) {
      $metadata = wp_get_attachment_metadata($id);
      if (!is_array($metadata)) {
        $skipped++;
        continue;
      }

      if (!empty($metadata['sizes']['sustainable_blurred'])) {
        $file = get_attached_file($id);
        $dir  = dirname($file);
        $blur = $dir . '/' . $metadata['sizes']['sustainable_blurred']['file'];
        if (file_exists($blur)) {
          $skipped++;
          continue;
        }
      }

      $updated = $this->generate_blurred_variant($metadata, $id);
      if (!empty($updated['sizes']['sustainable_blurred'])) {
        wp_update_attachment_metadata($id, $updated);
        $generated++;
      } else {
        $failed++;
      }
    }

    return new \WP_REST_Response([
      'success'   => true,
      'total'     => $total,
      'generated' => $generated,
      'skipped'   => $skipped,
      'failed'    => $failed,
      'message'   => sprintf(
        '%d blurred images generated, %d already existed, %d failed out of %d total.',
        $generated,
        $skipped,
        $failed,
        $total
      ),
    ], 200);
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
    add_image_size('sustainable_theme_pixelated', 16, 16, true);
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
   * Generate a small blurred variant after WordPress creates the standard sizes.
   * Uses ImageMagick if available, otherwise falls back to GD.
   */
  public function generate_blurred_variant(array $metadata, int $attachment_id): array
  {
    $file = get_attached_file($attachment_id);
    if (!$file || !file_exists($file)) {
      return $metadata;
    }

    $mime = get_post_mime_type($attachment_id);
    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
      return $metadata;
    }

    $dir  = dirname($file);
    $info = pathinfo($file);
    $ext  = $info['extension'] ?? 'jpg';
    $name = $info['filename'] ?? 'image';
    $dest = $dir . '/' . $name . self::BLURRED_SUFFIX . '.' . $ext;

    $orig_w = $metadata['width'] ?? 0;
    $orig_h = $metadata['height'] ?? 0;
    if ($orig_w === 0) {
      return $metadata;
    }

    $target_w = min(self::BLURRED_WIDTH, $orig_w);
    $ratio    = $target_w / $orig_w;
    $target_h = (int) round($orig_h * $ratio);

    $success = false;

    if (extension_loaded('imagick') && class_exists('Imagick')) {
      $success = $this->blur_with_imagick($file, $dest, $target_w, $target_h, $mime);
    }

    if (!$success && extension_loaded('gd')) {
      $success = $this->blur_with_gd($file, $dest, $target_w, $target_h, $mime);
    }

    if ($success && file_exists($dest)) {
      $metadata['sizes']['sustainable_blurred'] = [
        'file'      => basename($dest),
        'width'     => $target_w,
        'height'    => $target_h,
        'mime-type' => $mime,
      ];
    }

    return $metadata;
  }

  private function blur_with_imagick(string $src, string $dest, int $w, int $h, string $mime): bool
  {
    try {
      $img = new \Imagick($src);
      $img->resizeImage($w, $h, \Imagick::FILTER_LANCZOS, 1);
      $img->blurImage(0, self::BLUR_RADIUS);
      $img->setImageCompressionQuality(self::BLUR_QUALITY);
      $img->stripImage();
      $img->writeImage($dest);
      $img->destroy();
      return true;
    } catch (\Exception $e) {
      error_log('Sustainable theme blurred image (Imagick): ' . $e->getMessage());
      return false;
    }
  }

  private function blur_with_gd(string $src, string $dest, int $w, int $h, string $mime): bool
  {
    $source = match ($mime) {
      'image/jpeg' => @imagecreatefromjpeg($src),
      'image/png'  => @imagecreatefrompng($src),
      'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($src) : false,
      default      => false,
    };

    if (!$source) {
      return false;
    }

    $thumb = imagecreatetruecolor($w, $h);

    if ($mime === 'image/png' || $mime === 'image/webp') {
      imagealphablending($thumb, false);
      imagesavealpha($thumb, true);
    }

    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $w, $h, imagesx($source), imagesy($source));
    unset($source);

    // GD doesn't have a real Gaussian blur, so apply the built-in filter multiple times
    $passes = max(1, (int) (self::BLUR_RADIUS / 2));
    for ($i = 0; $i < $passes; $i++) {
      imagefilter($thumb, IMG_FILTER_GAUSSIAN_BLUR);
    }

    $ok = match ($mime) {
      'image/jpeg' => imagejpeg($thumb, $dest, self::BLUR_QUALITY),
      'image/png'  => imagepng($thumb, $dest, 8),
      'image/webp' => function_exists('imagewebp') ? imagewebp($thumb, $dest, self::BLUR_QUALITY) : false,
      default      => false,
    };

    unset($thumb);
    return (bool) $ok;
  }

  /**
   * Get the URL for the blurred variant of an attachment.
   * Returns null if no blurred variant exists.
   */
  public static function get_blurred_url(int $attachment_id): ?string
  {
    $metadata = wp_get_attachment_metadata($attachment_id);
    if (empty($metadata['sizes']['sustainable_blurred']['file'])) {
      return null;
    }

    $upload_dir = wp_get_upload_dir();
    $base_dir   = dirname($metadata['file'] ?? '');
    $blur_file  = $metadata['sizes']['sustainable_blurred']['file'];

    return trailingslashit($upload_dir['baseurl']) . trailingslashit($base_dir) . $blur_file;
  }

  /**
   * Update settings when they change
   */
  public function update_settings(string $option_name, $old_value, $new_value): void
  {
    if ($option_name === 'sustainable_theme_settings') {
      $this->settings = $new_value;
    }
  }
}
