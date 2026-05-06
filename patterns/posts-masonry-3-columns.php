<?php

/**
 * Title: Posts Masonry 3 Columns
 * Slug: sustainable-theme/posts-masonry-3-columns
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts
 * Description: A masonry-style grid of the latest posts with varied heights.
 * Keywords: posts, masonry, portfolio, blog, grid
 * Inserter: true
 */

?>
<!-- wp:group {"metadata":{"categories":["sustainable-theme","sustainable-theme/portfolio","sustainable-theme/posts"],"patternName":"sustainable-theme/posts-masonry-3-columns","name":"Posts masonry 3 columns"},"align":"wide","className":"sustainable-theme-post-grid sustainable-theme-posts-masonry","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide sustainable-theme-post-grid sustainable-theme-posts-masonry" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignwide" style="padding-top:0;padding-bottom:0"><!-- wp:query {"queryId":7,"query":{"perPage":12,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
    <div class="wp-block-query alignwide"><!-- wp:post-template {"className":"is-style-masonry","layout":{"type":"default"}} -->
      <!-- wp:group {"className":"sustainable-theme-masonry-item","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
      <div class="wp-block-group sustainable-theme-masonry-item" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"auto","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}}} /-->

        <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|fluid-x-small"}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"md"} /-->

        <!-- wp:post-excerpt {"moreText":"Read more","excerptLength":25,"style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"xs"} /-->
      </div>
      <!-- /wp:group -->
      <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->