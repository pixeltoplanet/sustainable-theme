<?php

/**
 * Title: Latest posts masonry
 * Slug: sustainable-theme/latest-posts-masonry
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts
 * Description: A masonry-style grid of the latest posts with varied heights.
 * Keywords: posts, masonry, portfolio, blog, grid
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","className":"sustainable-theme-post-grid sustainable-theme-posts-masonry","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sustainable-theme-post-grid sustainable-theme-posts-masonry" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:heading {"className":"is-style-subtitle"} -->
  <h2 class="wp-block-heading is-style-subtitle">Latest from the blog</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-x-small","bottom":"var:preset|spacing|fluid-medium"}}},"fontSize":"md"} -->
  <p class="has-md-font-size" style="margin-top:var(--wp--preset--spacing--fluid-x-small);margin-bottom:var(--wp--preset--spacing--fluid-medium)">Stories, insights, and updates from our team.</p>
  <!-- /wp:paragraph -->

  <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignfull" style="padding-top:0;padding-bottom:0"><!-- wp:query {"queryId":7,"query":{"perPage":12,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false}} -->
    <div class="wp-block-query"><!-- wp:post-template {"className":"is-style-masonry","layout":{"type":"default"}} -->
      <!-- wp:group {"className":"sustainable-theme-masonry-item","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
      <div class="wp-block-group sustainable-theme-masonry-item" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"auto","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}}} /-->

        <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|fluid-x-small"}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"md"} /-->

        <!-- wp:post-excerpt {"moreText":"Read more","excerptLength":25,"style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"sm"} /-->
      </div>
      <!-- /wp:group -->
      <!-- /wp:post-template -->

      <!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
      <!-- wp:query-pagination-previous /-->

      <!-- wp:query-pagination-numbers /-->

      <!-- wp:query-pagination-next /-->
      <!-- /wp:query-pagination -->
    </div>
    <!-- /wp:query -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->