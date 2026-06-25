<?php

/**
 * Title: Single post hero overlay
 * Slug: sustainable-theme/single-post-hero-overlay
 * Categories: sustainable-theme,sustainable-theme/single-post
 * Description: Full-width featured image cover with dark overlay and centered post meta.
 * Keywords: single post, hero, overlay, featured image, centered
 * Inserter: true
 */

?>
<!-- wp:cover {"useFeaturedImage":true,"dimRatio":50,"overlayColor":"foreground","isUserOverlayColor":true,"minHeight":70,"minHeightUnit":"vh","contentPosition":"center center","isDark":true,"align":"full","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}},"heading":{"color":{"text":"var:preset|color|background"}}},"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large","left":"var:preset|spacing|fluid-small","right":"var:preset|spacing|fluid-small"},"margin":{"top":"0","bottom":"0"}}},"textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull is-dark has-background-color has-text-color has-link-color" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--fluid-x-large);padding-right:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-x-large);padding-left:var(--wp--preset--spacing--fluid-small);min-height:70vh"><span aria-hidden="true" class="wp-block-cover__background has-foreground-background-color has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group alignwide"><!-- wp:post-terms {"term":"category","textAlign":"center","style":{"typography":{"textTransform":"uppercase","fontWeight":"600"}},"fontSize":"xs"} /-->

<!-- wp:post-title {"textAlign":"center","level":1,"className":"is-style-text-title"} /-->

<!-- wp:post-date {"textAlign":"center","fontSize":"sm"} /--></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
