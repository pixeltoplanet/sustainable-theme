<?php
/**
 * Extends the core Video block to enforce sustainable settings.
 *
 * Forces autoplay to be removed from the frontend output to save data
 * and improve accessibility.
 *
 * @package SustainableTheme
 */

if (!defined('ABSPATH')) {
  exit;
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

  $processor = new \WP_HTML_Tag_Processor($block_content);

  while ($processor->next_tag('VIDEO')) {
    $processor->remove_attribute('autoplay');
  }

  return $processor->get_updated_html();
}
add_filter('render_block', 'sustainable_theme_video_render_disable_autoplay', 10, 2);
