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
 * Filter the rendered output of `core/video` to strip the autoplay
 * attribute to prevent unwanted data consumption.
 *
 * @param string               $block_content Rendered block HTML.
 * @param array<string,mixed>  $block         Parsed block array.
 * @return string
 */
function sustainable_theme_video_render_disable_autoplay(string $block_content, array $block): string
{
  if (($block['blockName'] ?? '') !== 'core/video') {
    return $block_content;
  }

  // Strip autoplay attributes from the <video> tag
  // Matches `autoplay`, `autoplay="autoplay"`, `autoplay=""`, `autoplay="true"`
  $block_content = preg_replace('/\s+autoplay(=[\'"]?(autoplay|true|)[\'"]?)?/i', '', $block_content);

  return $block_content;
}
add_filter('render_block', 'sustainable_theme_video_render_disable_autoplay', 10, 2);
