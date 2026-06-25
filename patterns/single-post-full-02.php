<?php

/**
 * Title: Single post full 02
 * Slug: sustainable-theme/single-post-full-02
 * Categories: sustainable-theme,sustainable-theme/single-post,sustainable-theme/pages
 * Description: Full single post layout with overlay hero, wide content, and related posts.
 * Keywords: single post, full, overlay, content, related
 * Inserter: true
 */

?>
<!-- wp:pattern {"slug":"sustainable-theme/single-post-hero-overlay"} /-->

<!-- wp:post-content {"align":"wide","layout":{"type":"constrained"}} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-small","right":"var:preset|spacing|fluid-small"},"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--fluid-large);padding-right:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-large);padding-left:var(--wp--preset--spacing--fluid-small)"><!-- wp:heading {"align":"wide","className":"is-style-subtitle"} -->
<h2 class="wp-block-heading alignwide is-style-subtitle">Related posts</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":88,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"inherit":false}} -->
<div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-x-small"}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"sm"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
