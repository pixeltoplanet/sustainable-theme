<?php

/**
 * Title: Single post — Portfolio layout 01
 * Slug: sustainable-theme/single-post-portfolio-layout-01
 * Post Types: post
 * Categories: sustainable-theme,sustainable-theme/single-post-layout
 * Description: Portfolio post layout with intro, credits, and stacked image galleries.
 * Keywords: single post, portfolio, layout, gallery, credits
 * Inserter: true
 */

?>
<!-- wp:group {"metadata":{"name":"Portfolio post layout 01"},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns {"metadata":{"name":"Portfolio post introduction"}} -->
<div class="wp-block-columns"><!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-small","bottom":"var:preset|spacing|fluid-x-small"}}}} -->
<div class="wp-block-column" style="padding-top:var(--wp--preset--spacing--fluid-x-small);padding-bottom:var(--wp--preset--spacing--fluid-x-small)"><!-- wp:heading {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}},"fontSize":"xxl"} -->
<h2 class="wp-block-heading alignwide has-xxl-font-size" style="padding-top:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0)"><strong>Project title</strong></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-small"}}}} -->
<p style="padding-top:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-small)">Sint ipsum minim dolore excepteur adipisicing labore proident laborum ex aliquip. Nulla est nostrud ipsum. Et incididunt ad ullamco dolor. Ad commodo consequat sunt aliqua ea aute consequat duis pariatur esse. Cillum cillum esse esse cillum officia nostrud minim esse dolore aute laboris eu adipisicing.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"xs"} -->
<p class="has-xs-font-size"><strong>Credits</strong><br>Beeld: naam persoon<br>Auteur: schrijver<br>Project: naam project</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"metadata":{"name":"Portfolio post images"}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:gallery {"imageCrop":false,"linkTo":"none","aspectRatio":"3/4","metadata":{"name":"Gallery 3 columns"},"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-x-small","left":"var:preset|spacing|fluid-x-small"},"padding":{"top":"var:preset|spacing|fluid-x-small","bottom":"var:preset|spacing|fluid-x-small"}}}} -->
<figure class="wp-block-gallery has-nested-images columns-default" style="padding-top:var(--wp--preset--spacing--fluid-x-small);padding-bottom:var(--wp--preset--spacing--fluid-x-small)"><!-- wp:image {"aspectRatio":"3/4","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url(sustainable_theme_placeholder_image('portfolio-1')); ?>" alt="" style="aspect-ratio:3/4"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"3/4","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url(sustainable_theme_placeholder_image('portfolio-2')); ?>" alt="" style="aspect-ratio:3/4"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"3/4","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url(sustainable_theme_placeholder_image('portfolio-3')); ?>" alt="" style="aspect-ratio:3/4"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery -->

<!-- wp:gallery {"columns":2,"imageCrop":false,"linkTo":"none","aspectRatio":"16/9","metadata":{"name":"Gallery 2 columns"},"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-x-small","left":"var:preset|spacing|fluid-x-small"}}}} -->
<figure class="wp-block-gallery has-nested-images columns-2"><!-- wp:image {"aspectRatio":"16/9","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url(sustainable_theme_placeholder_image('portfolio-4')); ?>" alt="" style="aspect-ratio:16/9"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"16/9","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url(sustainable_theme_placeholder_image('portfolio-5')); ?>" alt="" style="aspect-ratio:16/9"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery -->

<!-- wp:gallery {"columns":1,"imageCrop":false,"linkTo":"none","aspectRatio":"16/9","metadata":{"name":"Gallery 1 column"},"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-x-small","left":"var:preset|spacing|fluid-x-small"},"padding":{"top":"var:preset|spacing|fluid-x-small","bottom":"var:preset|spacing|fluid-x-small"}}}} -->
<figure class="wp-block-gallery has-nested-images columns-1" style="padding-top:var(--wp--preset--spacing--fluid-x-small);padding-bottom:var(--wp--preset--spacing--fluid-x-small)"><!-- wp:image {"aspectRatio":"16/9","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url(sustainable_theme_placeholder_image('portfolio-6')); ?>" alt="" style="aspect-ratio:16/9"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
