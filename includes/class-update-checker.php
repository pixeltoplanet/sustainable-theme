<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Self-hosted update checker using plugin-update-checker.
 *
 * Uses GitHub Releases as the primary source. When a new release is
 * tagged (e.g. v1.1.0), the library detects it automatically and
 * offers the update in Appearance → Themes.
 *
 * Debug: enable WP_DEBUG and WP_DEBUG_LOG in wp-config.php, then check
 * wp-content/debug.log after Dashboard → Updates → Check Again.
 *
 * @package SustainableTheme
 * @since   1.0.0
 */
class UpdateChecker
{
  public function __construct()
  {
    add_action('init', [$this, 'init_update_checker']);
  }

  public function init_update_checker(): void
  {
    $autoload = get_template_directory() . '/vendor/autoload.php';
    if (!is_readable($autoload)) {
      $this->log('Update checker disabled: vendor/autoload.php not found. Install from a GitHub release zip that includes vendor/.');
      return;
    }
    require_once $autoload;

    if (!class_exists('\YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
      $this->log('Update checker disabled: plugin-update-checker library not loaded.');
      return;
    }

    $checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
      'https://github.com/pixeltoplanet/sustainable-theme/',
      get_template_directory() . '/style.css',
      'sustainable-theme'
    );

    $checker->setBranch('main');

    /** @var \YahnisElsts\PluginUpdateChecker\v5p7\Vcs\GitHubApi $api */
    $api = $checker->getVcsApi();
    $api->enableReleaseAssets('/sustainable-theme\.zip/');

    $this->log('Update checker initialized for ' . wp_get_theme()->get('Version'));
  }

  private function log(string $message): void
  {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
      return;
    }

    error_log('[Sustainable Theme Updates] ' . $message);
  }
}
