<?php

/**
 * Title: Posts grid 3 columns title over image
 * Slug: sustainable-theme/posts-grid-3-columns-title-over-image
 * Categories: sustainable-theme,sustainable-theme/posts
 * Description: A 3-column grid of the latest posts with the title overlaid on the featured image.
 * Keywords: posts, grid, title, image, cover, overlay
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Posts grid 3 columns title over image","categories":["sustainable-theme/posts"],"patternName":"sustainable-theme/posts-grid-3-columns-title-over-image"},"align":"wide","className":"sustainable-theme-grid","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide sustainable-theme-grid" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignwide" style="padding-top:0;padding-bottom:0"><!-- wp:query {"queryId":7,"query":{"perPage":12,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
    <div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"grid","columnCount":3}} -->
      <!-- wp:group {"className":"sustainable-theme-masonry-item","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
      <div class="wp-block-group sustainable-theme-masonry-item" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":30,"overlayColor":"foreground","isUserOverlayColor":true,"contentPosition":"bottom left","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-small","bottom":"var:preset|spacing|fluid-x-small","left":"var:preset|spacing|fluid-x-small","right":"var:preset|spacing|fluid-x-small"}},"dimensions":{"aspectRatio":"4/3"}},"layout":{"type":"constrained"}} -->
        <div class="wp-block-cover has-custom-content-position is-position-bottom-left" style="padding-top:var(--wp--preset--spacing--fluid-x-small);padding-right:var(--wp--preset--spacing--fluid-x-small);padding-bottom:var(--wp--preset--spacing--fluid-x-small);padding-left:var(--wp--preset--spacing--fluid-x-small)"><span aria-hidden="true" class="wp-block-cover__background has-foreground-background-color has-background-dim-30 has-background-dim"></span>
          <div class="wp-block-cover__inner-container"><!-- wp:post-title {"textAlign":"left","level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"0","right":"0","left":"0"},"padding":{"top":"var:preset|spacing|fluid-x-small","bottom":"var:preset|spacing|fluid-x-small","left":"var:preset|spacing|fluid-x-small","right":"var:preset|spacing|fluid-x-small"}},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background","fontSize":"lg"} /--></div>
        </div>
        <!-- /wp:cover -->
      </div>
      <!-- /wp:group -->
      <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->