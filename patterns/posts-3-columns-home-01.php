<?php

/**
 * Title: Posts 3 columns home 01
 * Slug: sustainable-theme/posts-3-columns-home-01
 * Categories: sustainable-theme,sustainable-theme/new,sustainable-theme/posts
 * Description: Three latest posts in a grid with section heading and intro.
 * Keywords: posts, blog, grid, columns, home
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large","left":"var:preset|spacing|fluid-small","right":"var:preset|spacing|fluid-small"},"margin":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--fluid-x-large);padding-right:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-x-large);padding-left:var(--wp--preset--spacing--fluid-small)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"center","className":"is-style-subtitle"} -->
<h2 class="wp-block-heading has-text-align-center is-style-subtitle">Latest insights</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"md"} -->
<p class="has-text-align-center has-md-font-size">Thoughts on design, strategy, and building products that people actually want to use.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":12,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-large"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","style":{"border":{"radius":{"topLeft":"var(\u002d\u002drounded-image)","topRight":"var(\u002d\u002drounded-image)","bottomLeft":"var(\u002d\u002drounded-image)","bottomRight":"var(\u002d\u002drounded-image)"}}}} /-->

<!-- wp:post-date {"fontSize":"xs"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"md","style":{"typography":{"fontStyle":"normal","fontWeight":"600"}}} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->
