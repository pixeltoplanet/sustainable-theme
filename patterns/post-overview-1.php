<?php

/**
 * Title: Post overview 1
 * Slug: sustainable-theme/post-overview-1
 * Categories: sustainable-theme,sustainable-theme/posts,sustainable-theme/new
 * Description: Blog overview with editorial section heading and 2-column post grid.
 * Keywords: posts, blog, overview, grid, editorial
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group"><!-- wp:heading {"className":"is-style-subtitle"} -->
    <h2 class="wp-block-heading is-style-subtitle">From the blog</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"fontSize":"md"} -->
    <p class="has-md-font-size">Thoughts, stories, and ideas from our team.</p>
    <!-- /wp:paragraph -->
  </div>
  <!-- /wp:group -->

  <!-- wp:query {"queryId":6,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
  <div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"16rem"}} -->
    <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small","padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","scale":"cover","style":{"border":{"radius":{"topLeft":"var(--rounded-image)","topRight":"var(--rounded-image)","bottomLeft":"var(--rounded-image)","bottomRight":"var(--rounded-image)"}},"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}}} /-->

      <!-- wp:post-date {"fontSize":"xs"} /-->

      <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0"}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"md"} /-->

      <!-- wp:post-excerpt {"excerptLength":20,"moreText":"","style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"sm"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->

    <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-medium"}}}} -->
    <!-- wp:query-pagination-previous /-->
    <!-- wp:query-pagination-numbers /-->
    <!-- wp:query-pagination-next /-->
    <!-- /wp:query-pagination -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->
