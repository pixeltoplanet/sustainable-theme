<?php

/**
 * Title: Single post hero simple
 * Slug: sustainable-theme/single-post-hero-simple
 * Categories: sustainable-theme,sustainable-theme/single-post
 * Description: Minimal text-only hero with category, title, date, and excerpt.
 * Keywords: single post, hero, simple, title, excerpt
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","backgroundColor":"neutral-1","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-small","right":"var:preset|spacing|fluid-small"},"margin":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group alignfull has-neutral-1-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--fluid-x-large);padding-right:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-large);padding-left:var(--wp--preset--spacing--fluid-small)"><!-- wp:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","fontWeight":"600"}},"fontSize":"xs"} /-->

<!-- wp:post-title {"level":1,"className":"is-style-text-title"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:post-date {"fontSize":"sm"} /-->

<!-- wp:post-author {"showAvatar":false,"byline":"By","fontSize":"sm"} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"fontSize":"lg"} /--></div>
<!-- /wp:group -->
