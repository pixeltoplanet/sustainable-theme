<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

class AdminMenu
{
  public function __construct()
  {
    add_action('admin_menu', [$this, 'add_admin_menu']);
    add_action('admin_enqueue_scripts', [$this, 'enqueue_react_assets']);
  }

  public function add_admin_menu(): void
  {
    // Check if the plugin menu already exists
    $plugin_menu_exists = $this->check_plugin_menu_exists();

    if (!$plugin_menu_exists) {
      // Create main menu if plugin doesn't exist
      add_menu_page(
        __('Sustainable theme', 'sustainable'),
        'Sustainable theme',
        'manage_options',
        'sustainable-theme',
        [$this, 'render_admin_page'],
        $this->get_menu_icon_svg(),
        30
      );
    }

    // Always add theme settings submenu
    add_submenu_page(
      'sustainable-theme',
      __('Theme Settings', 'sustainable'),
      __('Theme Settings', 'sustainable'),
      'manage_options',
      'sustainable-theme-settings',
      [$this, 'render_admin_page']
    );

    // Remove the default "Carbonfooter" submenu item if we created the main menu
    if (!$plugin_menu_exists) {
      remove_submenu_page('sustainable-theme', 'sustainable-theme');
    }
  }

  /**
   * Check if the sustainable theme plugin menu exists
   */
  private function check_plugin_menu_exists(): bool
  {
    global $menu;

    if (!$menu) {
      return false;
    }

    foreach ($menu as $item) {
      if (isset($item[2]) && $item[2] === 'sustainable-theme') {
        return true;
      }
    }

    return false;
  }

  private function get_menu_icon_svg(): string
  {
    $svg_content = '<svg fill="currentColor" height="20px" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 995 768"><path d="M102.26,600.22s-31.43-47.8-67.16-27.24c-41.94,24.74-15.18,73.97-15.18,73.97,0,0-38.96,43.14,5.38,69.43,49.47,29.52,67.88-24.74,67.88-24.74h0s65.6,4.55,66.68-49.35c.84-47.8-57.6-42.07-57.6-42.07Z"/><path d="M841.11,279.51c20.9-26.96,31.38-60.17,29.63-93.85-1.75-33.68-15.63-65.7-39.22-90.49C748.06-.49,627.65,55.4,627.65,55.4h0c-17.13-19.23-39.17-33.76-63.9-42.15-24.74-8.39-51.31-10.35-77.08-5.68-27.11,3.63-52.79,13.96-74.6,30-21.8,16.03-38.98,37.23-49.89,61.56,0,0-71.19-67.65-165.66,27.33-94.46,94.98-17.76,176.42-17.76,176.42,0,0-116.31,47.7-72.46,165.76,12.02,33.28,34.39,62.13,64.04,82.56,29.64,20.44,65.1,31.46,101.48,31.54,0,0-5.5,157.7,121.81,177.65,34.61,6.59,70.49,2.17,102.29-12.6,31.81-14.78,57.84-39.11,74.22-69.39,0,0,56.39,122.99,188.77,48.79,132.38-74.2,83.46-143.9,83.46-143.9,0,0,134.07-14.62,145.07-134.06,10.99-119.43-146.32-169.72-146.34-169.73ZM703.28,512.37c-17.09,24.09-39.63,43.27-67.63,57.55-28.01,14.28-61.89,21.42-101.65,21.42s-75.76-8.4-107.96-25.2c-32.21-16.8-57.69-41.17-76.45-73.09-18.77-31.92-28.14-70.28-28.14-115.1v-10.92c0-44.8,9.37-83.03,28.14-114.68,18.76-31.64,44.24-56,76.45-73.09,32.2-17.08,68.18-25.62,107.96-25.62s73.64,7.29,101.65,21.84c28,14.57,50.54,33.89,67.63,57.97,17.08,24.09,28.14,50.7,33.18,79.81l-84.01,17.64c-2.81-18.48-8.69-35.29-17.64-50.41-8.97-15.12-21.57-27.16-37.81-36.13-16.25-8.95-36.69-13.44-61.33-13.44s-45.79,5.46-65.11,16.38c-19.32,10.92-34.59,26.61-45.79,47.05-11.21,20.45-16.8,45.24-16.8,74.35v7.56c0,29.13,5.59,54.06,16.8,74.77,11.2,20.73,26.46,36.41,45.79,47.05,19.32,10.65,41.02,15.96,65.11,15.96,36.4,0,64.12-9.37,83.17-28.14,19.03-18.76,31.08-42.7,36.12-71.83l84.01,19.32c-6.72,28.56-18.63,54.9-35.71,78.97Z"/></svg>';
    return 'data:image/svg+xml;base64,' . base64_encode($svg_content);
  }

  public function render_admin_page(): void
  {
    echo '<div id="sustainable-theme-page-root"></div>';
  }

  public function enqueue_react_assets(): void
  {
    // Only load on our admin pages
    $screen = get_current_screen();
    if (!$screen || ($screen->id !== 'toplevel_page_sustainable-theme' && $screen->id !== 'sustainable-theme_page_sustainable-theme-settings')) {
      return;
    }

    // Always enqueue WordPress Components styles
    wp_enqueue_style('wp-components');

    $asset_file_path = SUSTAINABLE_THEME_DIR . '/build/admin.asset.php';

    if (file_exists($asset_file_path)) {
      $asset_data = include $asset_file_path;

      wp_enqueue_script(
        'sustainable-theme-admin',
        SUSTAINABLE_THEME_URL . '/build/admin.js',
        $asset_data['dependencies'],
        $asset_data['version'],
        true
      );

      // Enqueue CSS if it exists
      if (file_exists(SUSTAINABLE_THEME_DIR . '/build/admin.css')) {
        wp_enqueue_style(
          'sustainable-theme-admin',
          SUSTAINABLE_THEME_URL . '/build/admin.css',
          ['wp-components'],
          $asset_data['version']
        );
      }
    } else {
      // Fallback for development mode
      wp_enqueue_script(
        'sustainable-theme-admin',
        SUSTAINABLE_THEME_URL . '/build/admin.js',
        ['wp-element', 'wp-components', 'wp-i18n', 'wp-api-fetch'],
        SUSTAINABLE_THEME_VERSION,
        true
      );

      // Fallback CSS
      if (file_exists(SUSTAINABLE_THEME_DIR . '/build/admin.css')) {
        wp_enqueue_style(
          'sustainable-theme-admin',
          SUSTAINABLE_THEME_URL . '/build/admin.css',
          ['wp-components'],
          SUSTAINABLE_THEME_VERSION
        );
      }
    }

    // Localize script with nonce and REST API data
    wp_localize_script('sustainable-theme-admin', 'wpApiSettings', [
      'nonce' => wp_create_nonce('wp_rest'),
      'root' => esc_url_raw(rest_url()),
    ]);

  }
}
