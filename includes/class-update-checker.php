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
      return;
    }
    require_once $autoload;

    if (!class_exists('\YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
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
  }
}
