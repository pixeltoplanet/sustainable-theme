<?php

/**
 * Title: Posts horizontal scroll
 * Slug: sustainable-theme/posts-horizontal-scroll
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts
 * Description: Horizontally scrolling post cards.
 * Keywords: posts, horizontal, scroll, carousel
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","className":"sustainable-posts-horizontal","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sustainable-posts-horizontal" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:heading {"className":"is-style-subtitle","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-medium"}}}} -->
  <h2 class="wp-block-heading is-style-subtitle" style="margin-bottom:var(--wp--preset--spacing--fluid-medium)">More to explore</h2>
  <!-- /wp:heading -->

  <!-- wp:query {"queryId":11,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false}} -->
  <div class="wp-block-query"><!-- wp:post-template {"className":"sustainable-posts-scroll-grid","layout":{"type":"default"}} -->
    <!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-small","left":"var:preset|spacing|fluid-small","right":"var:preset|spacing|fluid-small"}}},"backgroundColor":"neutral-1","layout":{"type":"constrained"}} -->
    <div class="wp-block-group has-neutral-1-background-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-small);padding-right:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-small);padding-left:var(--wp--preset--spacing--fluid-small)"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}}} /-->

      <!-- wp:post-title {"level":3,"isLink":true,"fontSize":"md"} /-->

      <!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"fontSize":"xs"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->