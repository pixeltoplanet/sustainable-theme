<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Design tokens (border radius, etc.) exposed as CSS custom properties and
 * synced into theme.json for the site editor where possible.
 */
class DesignSettings
{
  public const OPTION = 'sustainable_theme_design_settings';

  public function __construct()
  {
    add_action('rest_api_init', [$this, 'register_routes']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_css_variables'], 100);
    add_action('enqueue_block_assets', [$this, 'enqueue_css_variables'], 100);
    add_action('wp_head', [$this, 'print_css_variables_tag'], 999);
    add_filter('wp_theme_json_data_theme', [$this, 'filter_theme_json']);
  }

  /**
   * @return array<string, string>
   */
  public static function get_defaults(): array
  {
    return [
      'rounded_card' => '15px',
      'rounded_image' => '15px',
      'rounded_button' => '4px',
    ];
  }

  /**
   * @return array<string, string>
   */
  public function get_settings(): array
  {
    $stored = get_option(self::OPTION, []);

    if (!is_array($stored)) {
      $stored = [];
    }

    return array_merge(self::get_defaults(), $stored);
  }

  /**
   * @param array<string, mixed> $settings
   * @return array<string, string>
   */
  public function sanitize_settings(array $settings): array
  {
    $defaults = self::get_defaults();
    $sanitized = [];

    foreach ($defaults as $key => $default) {
      $value = $settings[$key] ?? $default;
      $sanitized[$key] = $this->sanitize_radius_value((string) $value, $default);
    }

    return $sanitized;
  }

  public function register_routes(): void
  {
    register_rest_route('sustainable-theme/v1', '/design-settings', [
      [
        'methods' => 'GET',
        'callback' => [$this, 'rest_get_settings'],
        'permission_callback' => [$this, 'check_permissions'],
      ],
      [
        'methods' => 'POST',
        'callback' => [$this, 'rest_update_settings'],
        'permission_callback' => [$this, 'check_permissions'],
        'args' => [
          'settings' => [
            'required' => true,
            'type' => 'object',
          ],
        ],
      ],
    ]);
  }

  public function rest_get_settings(): \WP_REST_Response
  {
    return new \WP_REST_Response([
      'success' => true,
      'settings' => $this->get_settings(),
    ]);
  }

  public function rest_update_settings(\WP_REST_Request $request): \WP_REST_Response
  {
    $incoming = $request->get_param('settings');

    if (!is_array($incoming)) {
      return new \WP_REST_Response([
        'success' => false,
        'message' => __('Invalid design settings payload.', 'sustainable-theme'),
      ], 400);
    }

    $sanitized = $this->sanitize_settings($incoming);
    update_option(self::OPTION, $sanitized);

    return new \WP_REST_Response([
      'success' => true,
      'message' => __('Design settings saved successfully.', 'sustainable-theme'),
      'settings' => $sanitized,
    ]);
  }

  public function check_permissions(): bool
  {
    return current_user_can('manage_options');
  }

  public function enqueue_css_variables(): void
  {
    $css = $this->get_css_variables();

    if (wp_style_is('sustainable-theme-frontend-styles', 'enqueued')) {
      wp_add_inline_style('sustainable-theme-frontend-styles', $css);
      return;
    }

    wp_register_style('sustainable-theme-design-vars', false, [], SUSTAINABLE_THEME_VERSION);
    wp_enqueue_style('sustainable-theme-design-vars');
    wp_add_inline_style('sustainable-theme-design-vars', $css);
  }

  public function print_css_variables_tag(): void
  {
    printf(
      '<style id="sustainable-theme-design-vars">%s</style>',
      wp_strip_all_tags($this->get_css_variables())
    );
  }

  public function get_css_variables(): string
  {
    $settings = $this->get_settings();

    return sprintf(
      ':root{--rounded-card:%1$s;--rounded-image:%2$s;--rounded-button:%3$s;}',
      esc_attr($settings['rounded_card']),
      esc_attr($settings['rounded_image']),
      esc_attr($settings['rounded_button'])
    );
  }

  /**
   * Expose token values to theme.json (Site Editor global styles UI).
   *
   * @param \WP_Theme_JSON_Data $theme_json Theme JSON data object.
   */
  public function filter_theme_json(\WP_Theme_JSON_Data $theme_json): \WP_Theme_JSON_Data
  {
    $data = $theme_json->get_data();
    $settings = $this->get_settings();

    if (!isset($data['settings']['custom']) || !is_array($data['settings']['custom'])) {
      $data['settings']['custom'] = [];
    }

    $data['settings']['custom']['rounded'] = [
      'card' => $settings['rounded_card'],
      'image' => $settings['rounded_image'],
      'button' => $settings['rounded_button'],
    ];

    if (!isset($data['styles']['elements']['button']) || !is_array($data['styles']['elements']['button'])) {
      $data['styles']['elements']['button'] = [];
    }

    if (!isset($data['styles']['elements']['button']['border']) || !is_array($data['styles']['elements']['button']['border'])) {
      $data['styles']['elements']['button']['border'] = [];
    }

    $data['styles']['elements']['button']['border']['radius'] = 'var(--rounded-button)';

    return new \WP_Theme_JSON_Data($data, 'theme');
  }

  private function sanitize_radius_value(string $value, string $fallback): string
  {
    $value = trim(sanitize_text_field($value));

    if ($value === '0') {
      return '0';
    }

    if (preg_match('/^\d+(\.\d+)?$/', $value) === 1) {
      return $value . 'px';
    }

    if (preg_match('/^(\d+(\.\d+)?(px|rem|em|%|vh|vw))$/', $value) === 1) {
      return $value;
    }

    return $fallback;
  }
}
