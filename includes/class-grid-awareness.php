<?php

namespace SustainableTheme;

/**
 * Grid Awareness Class
 *
 * Fetches carbon intensity level from the Electricity Maps API, caches it
 * with WordPress transients, renders a top bar, and adds body classes so
 * that CSS and PHP can adapt to grid conditions.
 *
 * @package SustainableTheme
 * @since   1.0.0
 */
class GridAwareness
{
  private const API_BASE = 'https://api.electricitymap.org/v3';
  private const TRANSIENT_PREFIX = 'sustainable_grid_';

  private array $settings;

  /** @var array{level: string, zone: string, datetime: string|null}|null */
  private ?array $grid_data = null;

  private static array $zone_names = [
    'NL'  => 'Netherlands',
    'DE'  => 'Germany',
    'FR'  => 'France',
    'GB'  => 'United Kingdom',
    'ES'  => 'Spain',
    'IT'  => 'Italy',
    'SE'  => 'Sweden',
    'NO'  => 'Norway',
    'DK'  => 'Denmark',
    'BE'  => 'Belgium',
    'AT'  => 'Austria',
    'CH'  => 'Switzerland',
    'PL'  => 'Poland',
    'PT'  => 'Portugal',
    'FI'  => 'Finland',
    'IE'  => 'Ireland',
    'US'  => 'United States',
    'CA'  => 'Canada',
    'AU'  => 'Australia',
    'JP'  => 'Japan',
    'IN'  => 'India',
    'BR'  => 'Brazil',
  ];

  private static array $level_messages = [
    'low'    => 'Your local grid: Cleaner than average.',
    'medium' => 'Your local grid: About average.',
    'high'   => 'Your local grid: Dirtier than average.',
  ];

  public function __construct()
  {
    $this->settings = get_option('sustainable_theme_settings', []);

    if (!$this->is_enabled()) {
      return;
    }

    add_filter('body_class', [$this, 'add_body_classes']);
    add_action('wp_body_open', [$this, 'render_top_bar']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    add_action('wp_head', [$this, 'add_meta']);
    add_action('rest_api_init', [$this, 'register_rest_routes']);
    add_action('updated_option', [$this, 'on_settings_update'], 10, 3);
  }

  // ──────────────────────────────────────────────────────────────
  // Public API
  // ──────────────────────────────────────────────────────────────

  /**
   * Get grid data for use by other theme code or plugins.
   *
   * @return array{level: string, zone: string, zone_name: string, message: string, datetime: string|null}
   */
  public static function get_status(): array
  {
    $instance = new self();
    $data = $instance->get_grid_data();

    return [
      'level'     => $data['level'],
      'zone'      => $data['zone'],
      'zone_name' => self::get_zone_name($data['zone']),
      'message'   => self::$level_messages[$data['level']] ?? '',
      'datetime'  => $data['datetime'],
    ];
  }

  // ──────────────────────────────────────────────────────────────
  // Hooks
  // ──────────────────────────────────────────────────────────────

  public function add_body_classes(array $classes): array
  {
    if (is_admin()) {
      return $classes;
    }

    $data = $this->get_grid_data();
    $level = $data['level'];

    $classes[] = 'grid-intensity-' . $level;

    /** Allow plugins to modify grid-related body classes. */
    $classes = apply_filters('sustainable_grid_body_classes', $classes, $level, $data);

    return $classes;
  }

  public function render_top_bar(): void
  {
    if (is_admin()) {
      return;
    }

    $data      = $this->get_grid_data();
    $level     = esc_attr($data['level']);
    $zone      = esc_html($data['zone']);
    $zone_name = esc_html(self::get_zone_name($data['zone']));
    $message   = esc_html(self::$level_messages[$data['level']] ?? '');

    $html = '<div id="grid-aware-bar" class="grid-aware-bar grid-aware-bar--' . $level . '" role="status" aria-label="' . esc_attr__('Grid awareness status', 'sustainable-theme') . '">';
    $html .= '  <div class="grid-aware-bar__inner">';

    // Left: zone
    $html .= '    <div class="grid-aware-bar__zone">';
    $html .= '      <svg class="grid-aware-bar__icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>';
    $html .= '      <span>' . $zone_name . '</span>';
    $html .= '    </div>';

    // Center: status
    $html .= '    <div class="grid-aware-bar__status">';
    $html .= '      <span class="grid-aware-bar__dot"></span>';
    $html .= '      <span class="grid-aware-bar__message">' . $message . '</span>';
    $html .= '    </div>';

    // Right: mode indicator
    $html .= '    <div class="grid-aware-bar__mode">';
    $html .= '      <span class="grid-aware-bar__mode-label">' . esc_html__('Grid-aware mode', 'sustainable-theme') . '</span>';
    $html .= '      <span class="grid-aware-bar__toggle" role="img" aria-label="' . esc_attr__('Active', 'sustainable-theme') . '"><span class="grid-aware-bar__toggle-track"><span class="grid-aware-bar__toggle-thumb"></span></span></span>';
    $html .= '      <span class="grid-aware-bar__auto">' . esc_html__('Auto', 'sustainable-theme') . '</span>';
    $html .= '      <button type="button" class="grid-aware-bar__info" aria-label="' . esc_attr__('About grid awareness', 'sustainable-theme') . '" data-grid-info-toggle>';
    $html .= '        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
    $html .= '      </button>';
    $html .= '    </div>';

    $html .= '  </div>';

    // Info panel (hidden by default)
    $html .= '  <div class="grid-aware-bar__info-panel" hidden>';
    $html .= '    <p>' . esc_html__('This website adapts to the carbon intensity of your local electricity grid. When renewable energy is abundant, you get the full experience. When the grid is dirtier, we reduce page weight to lower environmental impact.', 'sustainable-theme') . '</p>';
    $html .= '  </div>';

    $html .= '</div>';

    /** Allow plugins to modify the top bar HTML. */
    $html = apply_filters('sustainable_grid_bar_html', $html, $data);

    echo $html;
  }

  public function enqueue_assets(): void
  {
    wp_enqueue_style(
      'sustainable-grid-aware-styles',
      SUSTAINABLE_THEME_URL . '/build/grid-aware-styles.css',
      [],
      SUSTAINABLE_THEME_VERSION
    );

    $asset_path = SUSTAINABLE_THEME_DIR . '/build/frontend.asset.php';
    $asset = is_readable($asset_path) ? include $asset_path : [];

    wp_enqueue_script(
      'sustainable-grid-aware-frontend',
      SUSTAINABLE_THEME_URL . '/build/frontend.js',
      is_array($asset) ? ($asset['dependencies'] ?? []) : [],
      is_array($asset) ? (string) ($asset['version'] ?? SUSTAINABLE_THEME_VERSION) : SUSTAINABLE_THEME_VERSION,
      true
    );

    wp_localize_script('sustainable-grid-aware-frontend', 'sustainableGridSettings', [
      'enabled'  => true,
      'apiUrl'   => rest_url('sustainable-theme/v1/grid-status'),
      'level'    => $this->get_grid_data()['level'],
    ]);
  }

  public function add_meta(): void
  {
    $data = $this->get_grid_data();
    echo '<meta name="grid-intensity" content="' . esc_attr($data['level']) . '" />' . "\n";
  }

  public function register_rest_routes(): void
  {
    register_rest_route('sustainable-theme/v1', '/grid-status', [
      'methods'             => 'GET',
      'callback'            => [$this, 'rest_get_status'],
      'permission_callback' => '__return_true',
    ]);

    register_rest_route('sustainable-theme/v1', '/grid-test', [
      'methods'             => 'POST',
      'callback'            => [$this, 'rest_test_connection'],
      'permission_callback' => function () {
        return current_user_can('manage_options');
      },
    ]);
  }

  public function rest_get_status(): \WP_REST_Response
  {
    $data = $this->get_grid_data();

    return new \WP_REST_Response([
      'success' => true,
      'data'    => [
        'level'     => $data['level'],
        'zone'      => $data['zone'],
        'zone_name' => self::get_zone_name($data['zone']),
        'message'   => self::$level_messages[$data['level']] ?? '',
        'datetime'  => $data['datetime'],
      ],
    ], 200);
  }

  public function rest_test_connection(): \WP_REST_Response
  {
    $api_key = $this->settings['electricity_maps_api_key'] ?? '';
    $zone    = $this->settings['grid_awareness_zone'] ?? 'NL';

    if (empty($api_key)) {
      return new \WP_REST_Response([
        'success' => false,
        'message' => 'No API key configured.',
      ], 400);
    }

    $result = $this->fetch_from_api($api_key, $zone);

    if (is_wp_error($result)) {
      return new \WP_REST_Response([
        'success' => false,
        'message' => $result->get_error_message(),
      ], 502);
    }

    return new \WP_REST_Response([
      'success' => true,
      'message' => 'Connection successful.',
      'data'    => $result,
    ], 200);
  }

  public function on_settings_update(string $option, $old, $new): void
  {
    if ($option !== 'sustainable_theme_settings') {
      return;
    }

    $this->settings = is_array($new) ? $new : [];

    $old_zone = is_array($old) ? ($old['grid_awareness_zone'] ?? '') : '';
    $new_zone = $this->settings['grid_awareness_zone'] ?? '';

    if ($old_zone !== $new_zone) {
      delete_transient(self::TRANSIENT_PREFIX . sanitize_key($old_zone));
    }
  }

  // ──────────────────────────────────────────────────────────────
  // Data fetching & caching
  // ──────────────────────────────────────────────────────────────

  /**
   * Get grid data, from cache or API.
   *
   * @return array{level: string, zone: string, datetime: string|null}
   */
  private function get_grid_data(): array
  {
    if ($this->grid_data !== null) {
      return $this->grid_data;
    }

    $zone      = $this->settings['grid_awareness_zone'] ?? 'NL';
    $cache_key = self::TRANSIENT_PREFIX . sanitize_key($zone);
    $cached    = get_transient($cache_key);

    if ($cached !== false && is_array($cached)) {
      $this->grid_data = $cached;

      /** Allow overriding the intensity level. */
      $this->grid_data['level'] = apply_filters(
        'sustainable_grid_intensity_level',
        $this->grid_data['level'],
        $this->grid_data
      );

      return $this->grid_data;
    }

    $api_key = $this->settings['electricity_maps_api_key'] ?? '';

    if (empty($api_key)) {
      $this->grid_data = $this->get_fallback_data($zone);
      return $this->grid_data;
    }

    $result = $this->fetch_from_api($api_key, $zone);

    if (is_wp_error($result)) {
      error_log('Grid awareness API error: ' . $result->get_error_message());
      $this->grid_data = $this->get_fallback_data($zone);
      return $this->grid_data;
    }

    $cache_minutes = (int) ($this->settings['grid_awareness_cache_minutes'] ?? 15);
    set_transient($cache_key, $result, $cache_minutes * MINUTE_IN_SECONDS);

    do_action('sustainable_grid_intensity_updated', $result);

    $this->grid_data = $result;

    /** Allow overriding the intensity level. */
    $this->grid_data['level'] = apply_filters(
      'sustainable_grid_intensity_level',
      $this->grid_data['level'],
      $this->grid_data
    );

    return $this->grid_data;
  }

  /**
   * Try the Carbon Intensity Level endpoint first (free Carbon Aware key),
   * then fall back to the /home-assistant endpoint (free Home Assistant key).
   *
   * @return array{level: string, zone: string, datetime: string|null}|\WP_Error
   */
  private function fetch_from_api(string $api_key, string $zone): array|\WP_Error
  {
    $headers = ['auth-token' => $api_key];

    // 1. Try the Carbon Intensity Level API (free via forms.electricitymaps.com/carbon-aware)
    $result = $this->try_level_endpoint($zone, $headers);
    if (!is_wp_error($result)) {
      return $result;
    }

    // 2. Fall back to the /home-assistant endpoint (free via electricitymaps.com/free-tier-api)
    $result = $this->try_home_assistant_endpoint($zone, $headers);
    if (!is_wp_error($result)) {
      return $result;
    }

    return $result;
  }

  /**
   * /v3/carbon-intensity-level/latest — returns low/moderate/high directly.
   * Available with the free Carbon Aware API key (forms.electricitymaps.com/carbon-aware).
   */
  private function try_level_endpoint(string $zone, array $headers): array|\WP_Error
  {
    $url = self::API_BASE . '/carbon-intensity-level/latest?' . http_build_query(['zone' => $zone]);

    $response = wp_remote_get($url, ['headers' => $headers, 'timeout' => 10]);

    if (is_wp_error($response)) {
      return $response;
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
      return new \WP_Error('level_endpoint_unavailable', "Level API returned HTTP {$code}");
    }

    $json = json_decode(wp_remote_retrieve_body($response), true);

    if (!is_array($json) || empty($json['data'][0]['level'])) {
      return new \WP_Error('invalid_response', 'Unexpected Level API response.');
    }

    $raw_level = strtolower($json['data'][0]['level']);
    $level = ($raw_level === 'moderate') ? 'medium' : $raw_level;

    if (!in_array($level, ['low', 'medium', 'high'], true)) {
      $level = 'medium';
    }

    return [
      'level'    => $level,
      'zone'     => $json['zone'] ?? $zone,
      'datetime' => $json['data'][0]['datetime'] ?? null,
    ];
  }

  /**
   * /v3/home-assistant — returns carbonIntensity + fossilFuelPercentage.
   * Available with the free Home Assistant API key (electricitymaps.com/free-tier-api).
   * We derive the level from fossilFuelPercentage.
   */
  private function try_home_assistant_endpoint(string $zone, array $headers): array|\WP_Error
  {
    $url = self::API_BASE . '/home-assistant?' . http_build_query(['zone' => $zone]);

    $response = wp_remote_get($url, ['headers' => $headers, 'timeout' => 10]);

    if (is_wp_error($response)) {
      return $response;
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    if ($code !== 200) {
      $error_body = json_decode($body, true);
      $msg = $error_body['message'] ?? $error_body['error'] ?? "HTTP {$code}";
      return new \WP_Error('api_error', 'Electricity Maps: ' . $msg);
    }

    $json = json_decode($body, true);

    if (!is_array($json) || !isset($json['fossilFuelPercentage'])) {
      return new \WP_Error('invalid_response', 'Unexpected Home Assistant API response.');
    }

    $fossil = (float) $json['fossilFuelPercentage'];

    if ($fossil <= 40) {
      $level = 'low';
    } elseif ($fossil <= 60) {
      $level = 'medium';
    } else {
      $level = 'high';
    }

    return [
      'level'    => $level,
      'zone'     => $json['zone'] ?? $zone,
      'datetime' => $json['datetime'] ?? null,
    ];
  }

  private function get_fallback_data(string $zone): array
  {
    return [
      'level'    => 'low',
      'zone'     => $zone,
      'datetime' => null,
    ];
  }

  // ──────────────────────────────────────────────────────────────
  // Helpers
  // ──────────────────────────────────────────────────────────────

  private function is_enabled(): bool
  {
    $enabled = !empty($this->settings['use_grid_awareness']);
    $has_key = !empty($this->settings['electricity_maps_api_key']);
    $is_dev  = $this->is_development();

    return $enabled && ($has_key || $is_dev);
  }

  private function is_development(): bool
  {
    $url = home_url();
    return str_contains($url, 'localhost')
      || str_contains($url, '.local')
      || str_contains($url, '127.0.0.1');
  }

  private static function get_zone_name(string $zone): string
  {
    $base = strtoupper(explode('-', $zone)[0]);
    return self::$zone_names[$base] ?? $zone;
  }
}
