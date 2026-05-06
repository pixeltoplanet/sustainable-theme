<?php

/**
 * Title: Posts Masonry 3 Columns Cards
 * Slug: sustainable-theme/posts-masonry-3-columns-cards
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts
 * Description: A masonry-style grid of the latest posts with varied heights.
 * Keywords: posts, masonry, portfolio, blog, grid
 * Inserter: true
 */

?>
<!-- wp:group {"metadata":{"name":"Posts masonry 3 columns cards","categories":["sustainable-theme","sustainable-theme/portfolio","sustainable-theme/posts"],"patternName":"sustainable-theme/posts-masonry-3-columns-cards"},"align":"wide","className":"sustainable-theme-posts-masonry","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-small"}},"backgroundColor":"neutral-1","layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignwide sustainable-theme-posts-masonry has-neutral-1-background-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignwide" style="padding-top:0;padding-bottom:0"><!-- wp:query {"queryId":7,"query":{"perPage":12,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
      <div class="wp-block-query alignwide"><!-- wp:post-template {"layout":{"type":"default"}} -->
        <!-- wp:group {"className":"sustainable-theme-masonry-item","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
        <div class="wp-block-group sustainable-theme-masonry-item has-background-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"auto","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}}} /-->

          <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|fluid-x-small"}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"md"} /-->

          <!-- wp:post-excerpt {"moreText":"Read more","excerptLength":25,"sustainable_excerpt_hide_readmore":true,"style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"xs"} /-->
        </div>
        <!-- /wp:group -->
        <!-- /wp:post-template -->
      </div>
      <!-- /wp:query -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:group -->