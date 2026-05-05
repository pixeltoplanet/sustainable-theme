<?php
/**
 * Extends the core Video block to enforce sustainable settings.
 *
 * Removes the autoplay attribute from the block schema (disabling the
 * editor toggle) and strips it from front-end output using the WP
 * HTML API for safety.
 *
 * @package SustainableTheme
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Remove the `autoplay` attribute from the core/video block schema.
 *
 * With the attribute unregistered, WordPress:
 * - Will not render the Autoplay toggle in the block sidebar
 * - Will silently ignore any stored `autoplay` value in existing blocks
 *
 * @param array<string,mixed> $args Block-type args.
 * @param string              $name Block name.
 * @return array<string,mixed>
 */
function sustainable_theme_video_unregister_autoplay_attribute(array $args, string $name): array
{
  if ('core/video' !== $name) {
    return $args;
  }

  unset($args['attributes']['autoplay']);

  return $args;
}
add_filter('register_block_type_args', 'sustainable_theme_video_unregister_autoplay_attribute', 11, 2);

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
