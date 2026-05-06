<?php

/**
 * Title: Gallery masonry narrow
 * Slug: sustainable-theme/gallery-masonry-narrow
 * Categories: sustainable-theme,sustainable-theme/gallery
 * Description: Masonry-style image gallery with varied aspect ratios and narrow columns.
 * Keywords: gallery, masonry, images, narrow
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","className":"sustainable-theme-gallery-masonry","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sustainable-theme-gallery-masonry" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:heading {"className":"is-style-subtitle"} -->
  <h2 class="wp-block-heading is-style-subtitle">Our gallery</h2>
  <!-- /wp:heading -->

  <!-- wp:group {"className":"sustainable-theme-masonry-gallery","layout":{"type":"constrained"}} -->
  <div class="wp-block-group sustainable-theme-masonry-gallery"><!-- wp:image {"aspectRatio":"1","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange.webp" alt="" style="aspect-ratio:1" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"aspectRatio":"4/5","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-green.webp" alt="" style="aspect-ratio:4/5" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"aspectRatio":"3/4","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-blue.webp" alt="" style="aspect-ratio:3/4" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"aspectRatio":"16/9","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-yellow.webp" alt="" style="aspect-ratio:16/9" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"aspectRatio":"1","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange-light.webp" alt="" style="aspect-ratio:1" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"aspectRatio":"5/4","sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-green-light.webp" alt="" style="aspect-ratio:5/4" /></figure>
    <!-- /wp:image -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->