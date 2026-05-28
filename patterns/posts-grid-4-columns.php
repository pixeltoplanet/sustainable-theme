<?php

/**
 * Title: Posts grid 4 columns
 * Slug: sustainable-theme/posts-grid-4-columns
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts,sustainable-theme/new
 * Description: A 4-column grid of the latest posts with rounded featured images.
 * Keywords: posts, portfolio, blog, grid, query
 * Inserter: true
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-small"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-small)"><!-- wp:query {"queryId":6,"query":{"perPage":12,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
  <div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"14rem"}} -->
    <!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"inherit":false}} -->
    <div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/4","style":{"border":{"radius":{"topLeft":"15px","topRight":"15px","bottomLeft":"15px","bottomRight":"15px"}}}} /-->

      <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-x-small"}},"typography":{"fontStyle":"normal","fontWeight":"400"}},"fontSize":"sm"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->
