<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Settings Validator Class
 * 
 * Provides comprehensive validation for Sustainable Theme settings
 * to prevent configuration errors and ensure data integrity.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class SettingsValidator
{
  /**
   * Validate all settings
   * 
   * @param array $settings Settings array to validate
   * @return array Array of validation errors (empty if valid)
   */
  public static function validateSettings(array $settings): array
  {
    $errors = [];

    // Validate sustainability mode
    if (isset($settings['sustainability_mode'])) {
      $valid_modes = ['base', 'super', 'custom'];
      if (!in_array($settings['sustainability_mode'], $valid_modes)) {
        $errors[] = sprintf(
          __('Invalid sustainability mode. Must be one of: %s', 'sustainable'),
          implode(', ', $valid_modes)
        );
      }
    }

    // Validate post revisions limit
    if (isset($settings['limit_post_revisions'])) {
      $revisions = (int) $settings['limit_post_revisions'];
      if ($revisions < 0 || $revisions > 10) {
        $errors[] = __('Post revisions limit must be between 0 and 10', 'sustainable');
      }
    }

    // Validate above-fold image limit
    if (isset($settings['above_fold_image_limit'])) {
      $limit = (int) $settings['above_fold_image_limit'];
      if ($limit < 1 || $limit > 5) {
        $errors[] = __('Above-fold image limit must be between 1 and 5', 'sustainable');
      }
    }

    // Validate max image size
    if (isset($settings['max_image_size'])) {
      $valid_sizes = ['medium', 'large', 'full'];
      if (!in_array($settings['max_image_size'], $valid_sizes)) {
        $errors[] = sprintf(
          __('Invalid max image size. Must be one of: %s', 'sustainable'),
          implode(', ', $valid_sizes)
        );
      }
    }

    // Validate boolean settings
    $boolean_settings = [
      'dequeue_non_sustainable',
      'use_grid_awareness',
      'disable_rss_feed',
      'disable_emojis',
      'remove_embeds',
      'remove_header_metadata',
      'remove_rest_output',
      'disable_xmlrpc',
      'disable_self_pingbacks',
      'remove_jquery_migrate',
      'remove_shortlinks',
      'disable_heartbeat',
      'remove_query_strings',
      'disable_comments',
      'remove_wp_version',
      'remove_dns_prefetch',
      'disable_dashicons_frontend',
      'disable_file_editing',
      'reduce_heartbeat_frequency',
      'disable_gravatar',
      'remove_capital_p_dangit',
      'disable_automatic_updates',
      'remove_theme_editor',
      'enable_lazy_loading',
      'enable_image_optimization',
      'remove_default_image_sizes',
    ];

    foreach ($boolean_settings as $setting) {
      if (isset($settings[$setting])) {
        // Accept boolean, string boolean, or numeric boolean
        $value = $settings[$setting];
        if (!is_bool($value) && !in_array($value, [true, false, 'true', 'false', '1', '0', 1, 0])) {
          $errors[] = sprintf(__('Setting "%s" must be a boolean value', 'sustainable'), $setting);
        }
      }
    }

    // Validate string settings
    $string_settings = ['electricity_maps_api_key'];

    foreach ($string_settings as $setting) {
      if (isset($settings[$setting]) && !is_string($settings[$setting])) {
        $errors[] = sprintf(__('Setting "%s" must be a string value', 'sustainable'), $setting);
      }
    }

    // Validate API key format if provided
    if (!empty($settings['electricity_maps_api_key'])) {
      $api_key_errors = self::validateApiKey($settings['electricity_maps_api_key']);
      $errors = array_merge($errors, $api_key_errors);
    }

    // Validate setting dependencies
    $dependency_errors = self::validateDependencies($settings);
    $errors = array_merge($errors, $dependency_errors);

    return $errors;
  }

  /**
   * Validate API key format
   * 
   * @param string $api_key API key to validate
   * @return array Array of validation errors
   */
  public static function validateApiKey(string $api_key): array
  {
    $errors = [];

    // Remove any whitespace
    $api_key = trim($api_key);

    // Check if empty
    if (empty($api_key)) {
      return $errors; // Empty is allowed
    }

    // Check length (Electricity Maps API keys are typically 32 characters)
    if (strlen($api_key) !== 32) {
      $errors[] = __('Electricity Maps API key must be exactly 32 characters long', 'sustainable');
    }

    // Check format (alphanumeric characters only)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $api_key)) {
      $errors[] = __('Electricity Maps API key must contain only alphanumeric characters', 'sustainable');
    }

    return $errors;
  }

  /**
   * Validate setting dependencies
   * 
   * @param array $settings Settings array
   * @return array Array of validation errors
   */
  public static function validateDependencies(array $settings): array
  {
    $errors = [];

    // If grid awareness is enabled, API key should be provided
    if (!empty($settings['use_grid_awareness']) && empty($settings['electricity_maps_api_key'])) {
      $errors[] = __('Grid awareness requires an Electricity Maps API key', 'sustainable');
    }

    // If heartbeat is disabled, reduce frequency should not be enabled
    if (!empty($settings['disable_heartbeat']) && !empty($settings['reduce_heartbeat_frequency'])) {
      $errors[] = __('Cannot reduce heartbeat frequency when heartbeat is disabled', 'sustainable');
    }

    // If comments are disabled, related settings should be consistent
    if (!empty($settings['disable_comments'])) {
      // This is more of a warning than an error, but we'll log it
      Logger::info('Comments are disabled - this affects comment-related functionality', [
        'setting' => 'disable_comments',
        'impact' => 'Comments system completely removed'
      ]);
    }

    return $errors;
  }

  /**
   * Sanitize settings
   * 
   * @param array $settings Raw settings array
   * @return array Sanitized settings array
   */
  public static function sanitizeSettings(array $settings): array
  {
    $sanitized = [];

    // Sanitize sustainability mode
    if (isset($settings['sustainability_mode'])) {
      $valid_modes = ['base', 'super', 'custom'];
      $sanitized['sustainability_mode'] = in_array($settings['sustainability_mode'], $valid_modes)
        ? $settings['sustainability_mode']
        : 'base';
    }

    // Sanitize API key
    if (isset($settings['electricity_maps_api_key'])) {
      $sanitized['electricity_maps_api_key'] = sanitize_text_field($settings['electricity_maps_api_key']);
    }

    // Sanitize numeric settings
    if (isset($settings['limit_post_revisions'])) {
      $revisions = (int) $settings['limit_post_revisions'];
      $sanitized['limit_post_revisions'] = max(0, min(10, $revisions));
    }

    if (isset($settings['above_fold_image_limit'])) {
      $limit = (int) $settings['above_fold_image_limit'];
      $sanitized['above_fold_image_limit'] = max(1, min(5, $limit));
    }

    // Sanitize max image size
    if (isset($settings['max_image_size'])) {
      $valid_sizes = ['medium', 'large', 'full'];
      $sanitized['max_image_size'] = in_array($settings['max_image_size'], $valid_sizes)
        ? $settings['max_image_size']
        : 'large';
    }

    // Sanitize boolean settings
    $boolean_settings = [
      'dequeue_non_sustainable',
      'use_grid_awareness',
      'disable_rss_feed',
      'disable_emojis',
      'remove_embeds',
      'remove_header_metadata',
      'remove_rest_output',
      'disable_xmlrpc',
      'disable_self_pingbacks',
      'remove_jquery_migrate',
      'remove_shortlinks',
      'disable_heartbeat',
      'remove_query_strings',
      'disable_comments',
      'remove_wp_version',
      'remove_dns_prefetch',
      'disable_dashicons_frontend',
      'disable_file_editing',
      'reduce_heartbeat_frequency',
      'disable_gravatar',
      'remove_capital_p_dangit',
      'disable_automatic_updates',
      'remove_theme_editor',
      'enable_lazy_loading',
      'enable_image_optimization',
      'remove_default_image_sizes',
    ];

    foreach ($boolean_settings as $setting) {
      // Use array_key_exists instead of isset to preserve false values
      if (array_key_exists($setting, $settings)) {
        $value = $settings[$setting];
        // Handle various boolean representations
        if (is_string($value)) {
          $sanitized[$setting] = in_array(strtolower($value), ['true', '1', 'yes', 'on']);
        } else {
          $sanitized[$setting] = (bool) $value;
        }
      }
    }

    return $sanitized;
  }

  /**
   * Get validation summary
   * 
   * @param array $settings Settings to validate
   * @return array Validation summary
   */
  public static function getValidationSummary(array $settings): array
  {
    $errors = self::validateSettings($settings);
    $sanitized = self::sanitizeSettings($settings);

    return [
      'is_valid' => empty($errors),
      'errors' => $errors,
      'sanitized_settings' => $sanitized,
      'total_settings' => count($settings),
      'validated_at' => current_time('mysql')
    ];
  }
}
