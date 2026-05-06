<?php

/**
 * Title: Gallery grid
 * Slug: sustainable-theme/gallery-grid
 * Categories: sustainable-theme,sustainable-theme/gallery
 * Description: Image grid gallery.
 * Keywords: gallery, grid, images
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"},"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:heading {"className":"is-style-text-title"} -->
  <h2 class="wp-block-heading is-style-text-title">Our gallery</h2>
  <!-- /wp:heading -->

  <!-- wp:gallery {"linkTo":"none","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-small","left":"var:preset|spacing|fluid-small"},"margin":{"top":"var:preset|spacing|fluid-large","bottom":"0"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
  <figure class="wp-block-gallery has-nested-images columns-default is-cropped" style="margin-top:var(--wp--preset--spacing--fluid-large);margin-bottom:0"><!-- wp:image {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange.webp","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-green.webp","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-green.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-blue.webp","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-blue.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-yellow.webp","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-yellow.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange-light.webp","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange-light.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-green-light.webp","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-green-light.webp" alt="" /></figure>
    <!-- /wp:image -->
  </figure>
  <!-- /wp:gallery -->
</div>
<!-- /wp:group -->