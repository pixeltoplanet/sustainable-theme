<?php
/**
 * Extends the core Video block to enforce sustainable settings.
 *
 * Strips the `autoplay` attribute from the rendered frontend output of the
 * `core/video` block to save bandwidth and improve accessibility.
 *
 * Behaviour is gated by the `disable_video_autoplay` theme setting (defaults
 * to true). Toggling it off in Theme Settings → Sustainability restores
 * native core behaviour without requiring a rebuild.
 *
 * @package SustainableTheme
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Whether the autoplay-stripping behaviour is currently enabled.
 *
 * Wrapped in a function so the lookup happens at render time and respects
 * any in-request mutation of the option (e.g. during settings save flows).
 */
function sustainable_theme_video_autoplay_disabled(): bool
{
  $settings = get_option('sustainable_theme_settings', []);
  if (!is_array($settings) || !array_key_exists('disable_video_autoplay', $settings)) {
    // Setting absent (e.g. fresh install before first save) — default to
    // sustainable behaviour, matching get_default_settings().
    return true;
  }
  return (bool) $settings['disable_video_autoplay'];
}

/**
 * Strip the `autoplay` attribute from the rendered `core/video` HTML
 * to prevent unwanted data consumption.
 *
 * Uses WP_HTML_Tag_Processor instead of regex for safe, spec-compliant
 * HTML attribute removal.
 *
 * @param string              $block_content Rendered block HTML.
 * @param array<string,mixed> $block         Parsed block array.
 * @return string
 */
function sustainable_theme_video_render_disable_autoplay(string $block_content, array $block): string
{
  if (($block['blockName'] ?? '') !== 'core/video') {
    return $block_content;
  }

  if (!sustainable_theme_video_autoplay_disabled()) {
    return $block_content;
  }

  $processor = new \WP_HTML_Tag_Processor($block_content);

  while ($processor->next_tag('VIDEO')) {
    $processor->remove_attribute('autoplay');
  }

  return $processor->get_updated_html();
}
add_filter('render_block', 'sustainable_theme_video_render_disable_autoplay', 10, 2);
