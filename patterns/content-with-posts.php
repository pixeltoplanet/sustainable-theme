<?php

/**
 * Title: Content with posts
 * Slug: sustainable-theme/content-with-posts
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts
 * Description: A content section with a post grid.
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|section","bottom":"0"},"blockGap":"var:preset|spacing|two-xl"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--section);padding-bottom:0"><!-- wp:heading {"className":"is-style-subtitle"} -->
  <h2 class="wp-block-heading is-style-subtitle">We like to <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">design</mark> &amp; tell a story</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph {"fontSize":"lg"} -->
  <p class="has-lg-font-size">Eiusmod enim mollit est eiusmod cupidatat minim cillum. Dolore proident exercitation mollit exercitation ea id elit et non.</p>
  <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|four-xl","bottom":"var:preset|spacing|section"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--four-xl);padding-bottom:var(--wp--preset--spacing--section)"><!-- wp:query {"queryId":6,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
  <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|xl"}},"layout":{"type":"grid","columnCount":3}} -->
    <!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"inherit":false}} -->
    <div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1"} /-->

      <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|sm"}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"sm"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->