<?php

/**
 * Extends the core Post Excerpt block with a "Hide Read More" toggle.
 *
 * The custom attribute `sustainable_excerpt_hide_readmore` is stored directly on the
 * block and, when true, causes the read-more link to be stripped from the
 * front-end render output.
 *
 * @package SustainableTheme
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Attribute key used by both the JS editor control and this PHP filter.
 */
const SUSTAINABLE_EXCERPT_HIDE_READ_MORE_KEY = 'sustainable_excerpt_hide_readmore';

/**
 * Register the custom boolean attribute on the `core/post-excerpt` block.
 *
 * @param array<string,mixed> $args Block-type args.
 * @param string              $name Block name.
 * @return array<string,mixed>
 */
function sustainable_theme_excerpt_register_hide_readmore_attribute(array $args, string $name): array
{
  if ('core/post-excerpt' !== $name) {
    return $args;
  }

  $args['attributes'] = $args['attributes'] ?? [];
  $args['attributes'][SUSTAINABLE_EXCERPT_HIDE_READ_MORE_KEY] = [
    'type' => 'boolean',
    'default' => false,
  ];

  return $args;
}
add_filter('register_block_type_args', 'sustainable_theme_excerpt_register_hide_readmore_attribute', 11, 2);

/**
 * Filter the rendered output of `core/post-excerpt` to strip the read-more
 * link when the toggle is enabled.
 *
 * @param string               $block_content Rendered block HTML.
 * @param array<string,mixed>  $block         Parsed block array.
 * @return string
 */
function sustainable_theme_excerpt_render_hide_readmore(string $block_content, array $block): string
{
  if (
    ($block['blockName'] ?? '') !== 'core/post-excerpt' ||
    empty($block['attrs'][SUSTAINABLE_EXCERPT_HIDE_READ_MORE_KEY])
  ) {
    return $block_content;
  }

  // The read-more link is rendered as <p class="wp-block-post-excerpt__more-text">…</p>
  // or as <a …class="wp-block-post-excerpt__more-link"…>…</a>.
  // Strip the entire more-text wrapper paragraph if it exists.
  $block_content = preg_replace(
    '/<p\s[^>]*class="[^"]*wp-block-post-excerpt__more-text[^"]*"[^>]*>.*?<\/p>/s',
    '',
    $block_content
  );

  return $block_content;
}
add_filter('render_block', 'sustainable_theme_excerpt_render_hide_readmore', 10, 2);
