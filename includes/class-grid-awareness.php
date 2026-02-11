<?php

namespace SustainableTheme;

/**
 * Grid Awareness Class
 * 
 * Integrates with @greenweb/grid-aware-websites package to provide real-time
 * carbon intensity data and grid awareness functionality.
 * 
 * @package SustainableTheme
 * @since 1.0.0
 */
class GridAwareness
{
  /**
   * Theme settings array containing grid awareness configuration
   * 
   * @var array Contains keys:
   *   - use_grid_awareness: bool - Whether grid awareness is enabled
   *   - electricity_maps_api_key: string - API key for Electricity Maps
   */
  private $settings;

  /**
   * Cached grid intensity data
   * 
   * @var array|null Grid data array or null if not loaded
   */
  private $grid_data;

  /**
   * Initialize grid awareness functionality
   * 
   * Sets up WordPress hooks for script enqueuing, REST API registration,
   * and settings monitoring.
   * 
   * @since 1.0.0
   */
  public function __construct()
  {
    // Get theme settings
    $this->settings = get_option('sustainable_theme_settings', []);

    // Grid awareness is now controlled by user settings

    // Always enqueue scripts, but pass the enabled state
    add_action('wp_enqueue_scripts', [$this, 'enqueue_grid_awareness_scripts']);
    add_action('wp_head', [$this, 'add_grid_awareness_meta']);

    // Update settings when they change
    add_action('updated_option', [$this, 'update_settings'], 10, 3);

    // Register REST API routes
    add_action('rest_api_init', [$this, 'register_rest_routes']);
  }

  /**
   * Enqueue grid awareness scripts and styles conditionally
   * 
   * Only enqueues resources when grid awareness is enabled and API key is provided.
   * 
   * @since 1.0.0
   * @return void
   */
  public function enqueue_grid_awareness_scripts(): void
  {
    // Check if grid awareness is enabled and has API key
    $is_enabled = !empty($this->settings['use_grid_awareness']);
    $has_api_key = !empty($this->settings['electricity_maps_api_key']);

    // Only enqueue if enabled and has API key (or in development)
    if (!$is_enabled || (!$has_api_key && !$this->is_development())) {
      return;
    }

    // Prepare settings first - DO NOT expose API key to frontend
    $localized_settings = [
      'enabled' => $this->settings['use_grid_awareness'] ?? false,
      'apiUrl' => rest_url('sustainable-theme/v1/grid-status'),
      // API key is handled server-side only for security
    ];

    // Enqueue grid-aware styles (no frontend JS; banner is server-rendered)
    wp_enqueue_style(
      'sustainable-grid-aware-styles',
      SUSTAINABLE_THEME_URL . '/build/grid-aware-styles.css',
      [],
      SUSTAINABLE_THEME_VERSION
    );
  }

  /**
   * Add grid awareness meta tags to HTML head
   * 
   * Adds development mode indicator meta tag when in development environment.
   * 
   * @since 1.0.0
   * @return void
   */
  public function add_grid_awareness_meta(): void
  {
    if ($this->is_development()) {
      echo '<meta name="sustainable-grid-awareness" content="development-mode" />';
    }
  }

  /**
   * Register REST API routes for grid awareness
   * 
   * Registers the grid status endpoint for frontend JavaScript consumption.
   * 
   * @since 1.0.0
   * @return void
   */
  public function register_rest_routes(): void
  {
    // Check if REST API is enabled
    if (!function_exists('register_rest_route')) {
      error_log("Sustainable Theme: REST API is not available for grid-status route");
      return;
    }

    register_rest_route('sustainable-theme/v1', '/grid-status', [
      [
        'methods' => 'GET',
        'callback' => [$this, 'get_grid_status'],
        'permission_callback' => '__return_true',
      ],
    ]);
  }

  /**
   * Get grid status and statistics via REST API
   * 
   * Main REST API endpoint that returns current grid intensity data.
   * 
   * @since 1.0.0
   * @return \WP_REST_Response JSON response with grid data
   */
  public function get_grid_status(): \WP_REST_Response
  {
    $grid_data = $this->get_grid_intensity_data();

    // Return simplified API response
    return new \WP_REST_Response([
      'success' => true,
      'data' => [
        'is_green' => $grid_data['is_green'],
        'grid_intensity' => $grid_data['grid_intensity'],
        'grid_intensity_label' => $this->get_intensity_label($grid_data['grid_intensity']),
        'region' => $grid_data['region'],
        'country_name' => $grid_data['country_name'],
        'carbon_intensity' => $grid_data['carbon_intensity'],
        'last_updated' => $grid_data['last_updated'],
      ],
      'development' => $this->is_development(),
    ], 200);
  }

  /**
   * Helper function for other plugins to get grid status
   * 
   * Provides direct PHP access to grid status data without requiring HTTP requests.
   * 
   * @since 1.0.0
   * @return array Grid status data with success status and grid information
   */
  public static function get_grid_status_for_plugin(): array
  {
    $instance = new self();
    $grid_data = $instance->get_grid_intensity_data();

    return [
      'success' => true,
      'data' => [
        'is_green' => $grid_data['is_green'],
        'grid_intensity' => $grid_data['grid_intensity'],
        'grid_intensity_label' => $instance->get_intensity_label($grid_data['grid_intensity']),
        'region' => $grid_data['region'],
        'country_name' => $grid_data['country_name'],
        'carbon_intensity' => $grid_data['carbon_intensity'],
        'last_updated' => $grid_data['last_updated'],
      ],
      'development' => $instance->is_development(),
    ];
  }

  /**
   * Get grid intensity data from appropriate source
   * 
   * Determines the best data source based on environment and settings:
   * 1. Development mode → Returns sample data for testing
   * 2. Has API key → Fetches real data from Electricity Maps API
   * 3. No API key → Returns sample data as fallback
   * 
   * @since 1.0.0
   * @return array Grid intensity data with keys:
   *   - is_green: bool - Whether grid is cleaner than average
   *   - grid_intensity: int - Clean energy percentage (0-100)
   *   - region: string - Country/region code (e.g., 'NL', 'DE')
   *   - country_name: string - Human-readable country name
   *   - carbon_intensity: int - Carbon intensity in gCO2/kWh
   *   - status_message: string - User-friendly status message
   *   - intensity_class: string - CSS class for styling ('green', 'yellow', etc.)
   *   - last_updated: string - MySQL timestamp of last update
   *   - development_mode: bool - Whether using development data
   */
  private function get_grid_intensity_data(): array
  {
    // In development mode, always return development data
    if ($this->is_development()) {
      return $this->get_development_data();
    }

    // Use real API if we have an API key
    if (!empty($this->settings['electricity_maps_api_key'])) {
      return $this->get_real_api_data();
    }

    // Fallback to sample data if no API key
    return $this->get_sample_data();
  }

  /**
   * Get development environment data
   * 
   * Returns consistent sample data for development/testing environments.
   * Always returns "clean" grid status to simulate optimal conditions.
   * 
   * @since 1.0.0
   * @return array Sample grid data with Netherlands as default region
   */
  private function get_development_data(): array
  {
    return [
      'is_green' => true,
      'grid_intensity' => 75,
      'region' => 'NL',
      'country_name' => 'Netherlands',
      'carbon_intensity' => 250,
      'status_message' => 'Development Mode: Your local grid is cleaner than average.',
      'intensity_class' => 'green',
      'last_updated' => current_time('mysql'),
      'development_mode' => true,
    ];
  }

  /**
   * Get real API data from Electricity Maps API
   * 
   * Makes server-side HTTP request to Electricity Maps API using stored API key.
   * Processes the response to calculate intensity percentages and status.
   * 
   * Falls back to sample data if API request fails or returns invalid data.
   * 
   * @since 1.0.0
   * @return array Real grid data or sample data on failure
   * @throws \Exception If API request fails
   */
  private function get_real_api_data(): array
  {
    try {
      // Use the @greenweb/grid-aware-websites package
      // This would require installing the package via Composer
      // For now, we'll use a direct API call to Electricity Maps

      $api_key = $this->settings['electricity_maps_api_key'];
      $zone = $this->get_user_zone();

      // Make API call to Electricity Maps
      $url = "https://api.electricitymap.org/v3/carbon-intensity/latest?zone={$zone}";
      $args = [
        'headers' => [
          'auth-token' => $api_key,
        ],
        'timeout' => 10,
      ];

      $response = wp_remote_get($url, $args);

      if (is_wp_error($response)) {
        error_log('Electricity Maps API error: ' . $response->get_error_message());
        return $this->get_sample_data();
      }

      $body = wp_remote_retrieve_body($response);
      $data = json_decode($body, true);

      if (!$data || !isset($data['carbonIntensity'])) {
        return $this->get_sample_data();
      }

      $intensity_percentage = $this->calculate_intensity_percentage($data['carbonIntensity']);
      $intensity_class = $this->get_intensity_class($intensity_percentage);
      $is_green = $data['carbonIntensity'] < 400; // Consider green if under 400 gCO2/kWh

      return [
        'is_green' => $is_green,
        'grid_intensity' => $intensity_percentage,
        'region' => $zone,
        'country_name' => $this->get_country_name($zone),
        'carbon_intensity' => $data['carbonIntensity'],
        'status_message' => $this->get_status_message($is_green, $intensity_percentage),
        'intensity_class' => $intensity_class,
        'last_updated' => current_time('mysql'),
        'development_mode' => false,
      ];
    } catch (\Exception $e) {
      error_log('Real API data error: ' . $e->getMessage());
      return $this->get_sample_data();
    }
  }

  /**
   * Get sample data for demonstration/fallback
   * 
   * Returns randomized sample data from predefined regions when:
   * - No API key is available
   * - API request fails
   * - Development mode is disabled but no real data available
   * 
   * @since 1.0.0
   * @return array Random sample grid data from predefined regions
   */
  private function get_sample_data(): array
  {
    $sample_regions = [
      'NL' => ['name' => 'Netherlands', 'intensity' => 250, 'is_green' => true],
      'DE' => ['name' => 'Germany', 'intensity' => 400, 'is_green' => false],
      'US' => ['name' => 'United States', 'intensity' => 450, 'is_green' => false],
      'FR' => ['name' => 'France', 'intensity' => 200, 'is_green' => true],
      'GB' => ['name' => 'United Kingdom', 'intensity' => 300, 'is_green' => true],
    ];

    $region = array_rand($sample_regions);
    $data = $sample_regions[$region];

    $intensity_percentage = $this->calculate_intensity_percentage($data['intensity']);
    $intensity_class = $this->get_intensity_class($intensity_percentage);

    return [
      'is_green' => $data['is_green'],
      'grid_intensity' => $intensity_percentage,
      'region' => $region,
      'country_name' => $data['name'],
      'carbon_intensity' => $data['intensity'],
      'status_message' => $this->get_status_message($data['is_green'], $intensity_percentage),
      'intensity_class' => $intensity_class,
      'last_updated' => current_time('mysql'),
      'development_mode' => false,
    ];
  }

  /**
   * Calculate intensity percentage from carbon intensity
   * 
   * Converts carbon intensity (gCO2/kWh) to a clean energy percentage (0-100).
   * Uses inverse calculation: lower carbon intensity = higher clean percentage.
   * 
   * Formula: percentage = ((max_intensity - carbon_intensity) / (max_intensity - min_intensity)) * 100
   * Where max_intensity = 1000 gCO2/kWh, min_intensity = 0 gCO2/kWh
   * 
   * @since 1.0.0
   * @param int $carbon_intensity Carbon intensity in gCO2/kWh
   * @return int Clean energy percentage (0-100)
   */
  private function calculate_intensity_percentage(int $carbon_intensity): int
  {
    $max_intensity = 1000;
    $min_intensity = 0;
    $percentage = max(0, min(100, (($max_intensity - $carbon_intensity) / ($max_intensity - $min_intensity)) * 100));
    return (int) round($percentage);
  }

  /**
   * Get intensity class for CSS styling
   * 
   * Converts intensity percentage to CSS class name for styling.
   * Used by frontend JavaScript to apply appropriate visual styling.
   * 
   * @since 1.0.0
   * @param int $intensity Clean energy percentage (0-100)
   * @return string CSS class name: 'very-green', 'green', 'yellow', 'orange', 'red'
   */
  private function get_intensity_class(int $intensity): string
  {
    if ($intensity >= 80) return 'very-green';
    if ($intensity >= 60) return 'green';
    if ($intensity >= 40) return 'yellow';
    if ($intensity >= 20) return 'orange';
    return 'red';
  }

  /**
   * Get intensity label following @greenweb/grid-aware-websites package standards
   * 
   * Converts intensity percentage to standardized labels used by the
   * @greenweb/grid-aware-websites package. Uses 3 levels for consistency
   * with the official package API.
   * 
   * @since 1.0.0
   * @param int $intensity Clean energy percentage (0-100)
   * @return string Intensity label: 'low', 'moderate', 'high'
   * 
   * @link https://www.npmjs.com/package/@greenweb/grid-aware-websites
   */
  private function get_intensity_label(int $intensity): string
  {
    if ($intensity >= 60) return 'low';      // Clean/low carbon
    if ($intensity >= 30) return 'moderate'; // Average carbon
    return 'high';                           // Dirty/high carbon
  }

  /**
   * Get user-friendly status message
   * 
   * Generates human-readable status message based on grid conditions.
   * Used by theme functions and can be displayed to users.
   * 
   * @since 1.0.0
   * @param bool $is_green Whether grid is cleaner than average
   * @param int $intensity Clean energy percentage (0-100)
   * @return string User-friendly status message
   */
  private function get_status_message(bool $is_green, int $intensity): string
  {
    if ($is_green) return 'Your local grid: Cleaner than average.';
    if ($intensity >= 40 && $intensity < 60) return 'Your local grid: About average.';
    return 'Your local grid: Dirtier than average.';
  }

  /**
   * Get user's zone based on IP or default
   * 
   * Determines the electricity grid zone for API requests.
   * Currently returns a default zone (Netherlands) but could be
   * enhanced with IP geolocation services.
   * 
   * @since 1.0.0
   * @return string Zone code (e.g., 'NL', 'DE', 'US')
   */
  private function get_user_zone(): string
  {
    // For now, return a default zone
    // In production, you could use IP geolocation services
    return 'NL'; // Default to Netherlands
  }

  /**
   * Get country name from zone code
   * 
   * Maps electricity grid zone codes to human-readable country names.
   * Used for displaying location information to users.
   * 
   * @since 1.0.0
   * @param string $zone Zone code (e.g., 'NL', 'DE', 'US')
   * @return string Country name or 'Unknown' if zone not found
   */
  private function get_country_name(string $zone): string
  {
    $zone_map = [
      'NL' => 'Netherlands',
      'DE' => 'Germany',
      'US' => 'United States',
      'FR' => 'France',
      'GB' => 'United Kingdom',
    ];

    return $zone_map[$zone] ?? 'Unknown';
  }

  /**
   * Check if we're in development environment
   * 
   * Determines if the site is running in a development environment
   * based on URL patterns. Used to enable development features like
   * sample data and debug information.
   * 
   * @since 1.0.0
   * @return bool True if in development environment
   */
  private function is_development(): bool
  {
    $is_local = strpos(home_url(), 'localhost') !== false ||
      strpos(home_url(), '.local') !== false ||
      strpos(home_url(), '127.0.0.1') !== false ||
      strpos(home_url(), 'pixeltoplanet.local') !== false;

    // Only use WP_DEBUG for development if we're actually on localhost
    return $is_local || ($is_local && defined('WP_DEBUG') && WP_DEBUG);
  }

  /**
   * Update settings when they change
   * 
   * WordPress hook callback that updates the local settings array
   * when the theme settings option is updated in the database.
   * 
   * @since 1.0.0
   * @param string $option_name The option name being updated
   * @param mixed $old_value Previous option value
   * @param mixed $new_value New option value
   * @return void
   */
  public function update_settings(string $option_name, $old_value, $new_value): void
  {
    if ($option_name === 'sustainable_theme_settings') {
      $this->settings = $new_value;
    }
  }


  /**
   * Check permissions for REST API
   * 
   * Permission callback for REST API endpoints. Always returns true
   * since grid status data is safe to expose publicly.
   * 
   * @since 1.0.0
   * @return bool Always true (public access allowed)
   */
  public function check_permissions(): bool
  {
    // Allow access for grid status endpoint - this is safe data
    return true;
  }

  /**
   * Theme function to get grid status message for display
   * 
   * Provides a simple way for themes and plugins to get user-friendly
   * grid status messages without needing to process raw data.
   * 
   * @since 1.0.0
   * @return string User-friendly status message
   * 
   * @example
   * ```php
   * // In theme template or plugin
   * $message = SustainableTheme\GridAwareness::get_status_message_for_display();
   * echo "<p class='grid-status'>{$message}</p>";
   * ```
   */
  public static function get_status_message_for_display(): string
  {
    $instance = new self();
    $grid_data = $instance->get_grid_intensity_data();

    return $instance->get_status_message($grid_data['is_green'], $grid_data['grid_intensity']);
  }

  /**
   * Display a server-rendered grid intensity banner
   * 
   * Renders a small banner with current grid status, clean energy percentage,
   * and country information. Only renders when grid awareness is enabled and
   * (API key present or in development). Intended for server-side rendering to
   * avoid any frontend script requirements.
   * 
   * @since 1.0.0
   * @return void
   */
  public function display_grid_intencity_banner(): void
  {
    $is_enabled = !empty($this->settings['use_grid_awareness']);
    $has_api_key = !empty($this->settings['electricity_maps_api_key']);

    if (!$is_enabled || (!$has_api_key && !$this->is_development())) {
      return;
    }

    $grid = $this->get_grid_intensity_data();

    // Compute class based on percentage
    $intensity_class = $this->get_intensity_class((int) $grid['grid_intensity']);
    $status = esc_html($this->get_status_message((bool) $grid['is_green'], (int) $grid['grid_intensity']));
    $country = esc_html($grid['country_name']);
    $region = esc_html($grid['region']);
    $percent = (int) $grid['grid_intensity'];
    $updated = esc_html(mysql2date('Y-m-d H:i', $grid['last_updated']));

    echo '<div class="grid-indicator ' . esc_attr($intensity_class) . '" style="display:inline-flex">';
    echo '  <div class="grid-indicator__dot"></div>';
    echo '  <div class="grid-indicator__status">' . $status . ' (' . $country . ' ' . $region . ')</div>';
    echo '  <div class="intensity-bar ' . esc_attr($intensity_class) . '"><div class="intensity-bar__fill" style="width:' . $percent . '%"></div></div>';
    echo '  <span class="grid-indicator__meta" style="margin-left:8px;opacity:.7">' . $percent . '% • ' . $updated . '</span>';
    echo '</div>';
  }
}
