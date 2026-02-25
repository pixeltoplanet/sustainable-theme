<?php

/**
 * Title: Latest posts grid cards
 * Slug: sustainable-theme/latest-posts-grid-cards
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts
 * Description: A grid of the latest posts with cards.
 * Keywords: posts, portfolio, blog, overview, grid, cards
 * Inserter: true
 */
?>
<!-- wp:group {"align":"full","className":"sustainable-theme-post-grid","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sustainable-theme-post-grid" style="padding-top:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-small)"><!-- wp:query {"queryId":6,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
  <div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"grid","columnCount":3}} -->
    <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-small","left":"var:preset|spacing|fluid-small","right":"var:preset|spacing|fluid-small"}}},"backgroundColor":"neutral-1","layout":{"inherit":false}} -->
    <div class="wp-block-group has-neutral-1-background-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-small);padding-right:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-small);padding-left:var(--wp--preset--spacing--fluid-small)"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1"} /-->

      <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-x-small","bottom":"0"}},"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"md"} /-->

      <!-- wp:post-date {"datetime":"2026-02-25T15:10:29.139Z"} /-->

      <!-- wp:post-excerpt {"moreText":"Read more","excerptLength":20,"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}}},"fontSize":"sm"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->