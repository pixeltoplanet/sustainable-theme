<?php

/**
 * Title: Content gallery masonry
 * Slug: sustainable-theme/content-gallery-masonry
 * Categories: sustainable-theme,sustainable-theme/content,sustainable-theme/gallery
 * Description: Masonry-style image gallery with varied aspect ratios.
 * Keywords: content, gallery, masonry, images
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","className":"sustainable-gallery-masonry","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sustainable-gallery-masonry" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:group {"metadata":{"name":"Container"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignwide"><!-- wp:heading {"align":"full","className":"is-style-subtitle"} -->
    <h2 class="wp-block-heading alignfull is-style-subtitle">Portfolio</h2>
    <!-- /wp:heading -->

    <!-- wp:group {"align":"full","className":"sustainable-masonry-gallery","style":{"spacing":{"padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull sustainable-masonry-gallery" style="padding-right:0;padding-left:0"><!-- wp:image {"aspectRatio":"1","sizeSlug":"large","linkDestination":"none"} -->
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
</div>
<!-- /wp:group -->