<?php

/**
 * Title: Posts featured grid
 * Slug: sustainable-theme/posts-featured-grid
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts
 * Description: Featured post with smaller grid below.
 * Keywords: posts, featured, grid, blog
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","className":"sustainable-theme-post-grid","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sustainable-theme-post-grid" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:query {"queryId":9,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"include","inherit":false,"sustainable_exclude_current":true}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"default"}} -->
<!-- wp:group {"className":"sustainable-theme-featured-post","layout":{"type":"constrained"}} -->
<div class="wp-block-group sustainable-theme-featured-post"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"21/9","dimRatio":0} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small","padding":{"top":"var:preset|spacing|fluid-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--fluid-small)"><!-- wp:post-date {"fontSize":"xs"} /-->

<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"xl"} /-->

<!-- wp:post-excerpt {"excerptLength":35,"fontSize":"md"} /-->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->

<!-- wp:query {"queryId":10,"query":{"perPage":4,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"grid","columnCount":4}} -->
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"sm","style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-x-small"}}}} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
</div>
<!-- /wp:group -->
