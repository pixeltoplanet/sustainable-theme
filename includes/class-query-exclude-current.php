<?php
/**
 * Extends the core Query block with "exclude current post" for singular templates.
 *
 * The flag is stored on the query object as `sustainable_exclude_current` so it
 * flows to the Post Template block's REST preview (see core Post Template edit).
 *
 * @package SustainableTheme
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Default key merged into the Query block's `query` object.
 */
const SUSTAINABLE_QUERY_EXCLUDE_CURRENT_KEY = 'sustainable_exclude_current';

/**
 * Merge default for the `query` attribute on `core/query`.
 *
 * @param array<string,mixed> $args Block type args.
 * @return array<string,mixed>
 */
function sustainable_theme_query_exclude_register_attribute(array $args, string $name): array
{
  if ('core/query' !== $name) {
    return $args;
  }
  if (empty($args['attributes']['query']['default']) || !is_array($args['attributes']['query']['default'])) {
    return $args;
  }
  $args['attributes']['query']['default'] = array_merge(
    $args['attributes']['query']['default'],
    [SUSTAINABLE_QUERY_EXCLUDE_CURRENT_KEY => false]
  );
  return $args;
}
add_filter('register_block_type_args', 'sustainable_theme_query_exclude_register_attribute', 11, 2);

/**
 * On the front, exclude the current singular post from the loop when the flag is set
 * and the queried post type matches the loop's post type.
 *
 * @param array<string,mixed> $query Query vars.
 * @param \WP_Block           $block Block.
 * @param int                 $page  Page.
 * @return array<string,mixed>
 */
function sustainable_theme_query_loop_exclude_current(
  array $query,
  $block,
  int $page
): array {
  if (
    empty($block->context['query'][SUSTAINABLE_QUERY_EXCLUDE_CURRENT_KEY]) ||
    !is_singular()
  ) {
    return $query;
  }

  $qtype = $block->context['query']['postType'] ?? 'post';
  if (!is_string($qtype) || $qtype === '') {
    $qtype = 'post';
  }
  if (!is_post_type_viewable($qtype)) {
    return $query;
  }

  $id = (int) get_queried_object_id();
  if ($id < 1 || get_post_type($id) !== $qtype) {
    return $query;
  }

  $not_in = $query['post__not_in'] ?? [];
  if (!is_array($not_in)) {
    $not_in = [];
  }
  $not_in[] = $id;
  $query['post__not_in'] = array_values(array_unique(array_map('absint', $not_in)));

  return $query;
}
add_filter('query_loop_block_query_vars', 'sustainable_theme_query_loop_exclude_current', 10, 3);

/**
 * Register the REST param on every public post type so editor previews can pass the flag.
 */
function sustainable_theme_register_rest_exclude_param(): void
{
  $types = get_post_types(
    [
      'public' => true,
      'show_in_rest' => true,
    ],
    'names'
  );
  foreach ($types as $post_type) {
    add_filter(
      "rest_{$post_type}_collection_params",
      'sustainable_theme_rest_collection_add_exclude_current_param',
      10,
      1
    );
    add_filter("rest_{$post_type}_query", 'sustainable_theme_rest_apply_exclude_current', 10, 2);
  }
}
add_action('rest_api_init', 'sustainable_theme_register_rest_exclude_param', 5);

/**
 * @param array<string,mixed> $params Collection params.
 * @return array<string,mixed>
 */
function sustainable_theme_rest_collection_add_exclude_current_param(array $params): array
{
  $params[SUSTAINABLE_QUERY_EXCLUDE_CURRENT_KEY] = [
    'type' => 'boolean',
    'default' => false,
  ];
  return $params;
}

/**
 * Mirror Post Template preview: add current editor post to post__not_in when requested.
 * Uses the referer (post.php?post=) when the block editor fetches the posts list.
 *
 * @param array<string,mixed>           $args    Args for WP_Query.
 * @param \WP_REST_Request<array> $request Request.
 * @return array<string,mixed>
 */
function sustainable_theme_rest_apply_exclude_current(
  array $args,
  $request
): array {
  if (
    !$request instanceof \WP_REST_Request
    || !$request->get_param(SUSTAINABLE_QUERY_EXCLUDE_CURRENT_KEY)
  ) {
    return $args;
  }

  $referer = wp_get_referer();
  if (!is_string($referer) || $referer === '' || !preg_match('/[?&]post=(\d+)/', $referer, $m)) {
    return $args;
  }
  $id = absint($m[1]);
  if ($id < 1) {
    return $args;
  }

  $not_in = $args['post__not_in'] ?? [];
  if (!is_array($not_in)) {
    $not_in = [];
  }
  $not_in[] = $id;
  $args['post__not_in'] = array_values(array_unique(array_map('absint', $not_in)));

  return $args;
}
