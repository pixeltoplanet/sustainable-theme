<?php

/**
 * Title: Single post hero cover
 * Slug: sustainable-theme/single-post-hero-cover
 * Categories: sustainable-theme,sustainable-theme/single-post
 * Description: Featured image cover with post title, date, and category at the bottom.
 * Keywords: single post, hero, cover, featured image, title
 * Inserter: true
 */

?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:cover {"useFeaturedImage":true,"dimRatio":50,"overlayColor":"foreground","isUserOverlayColor":true,"minHeight":50,"minHeightUnit":"vh","contentPosition":"bottom left","isDark":true,"sizeSlug":"full","align":"wide","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}},"heading":{"color":{"text":"var:preset|color|background"}}},"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-60"},"margin":{"bottom":"var:preset|spacing|fluid-medium"}}},"textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignwide is-dark has-custom-content-position is-position-bottom-left has-background-color has-text-color has-link-color" style="margin-bottom:var(--wp--preset--spacing--fluid-medium);padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--60);min-height:50vh"><span aria-hidden="true" class="wp-block-cover__background has-foreground-background-color has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:post-terms {"term":"category","style":{"typography":{"textTransform":"uppercase","fontWeight":"600"}},"fontSize":"xs"} /-->

<!-- wp:post-title {"textAlign":"left","level":1,"className":"is-style-text-title"} /-->

<!-- wp:post-date {"fontSize":"sm"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->
