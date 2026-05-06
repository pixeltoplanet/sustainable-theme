<?php

/**
 * Title: Gallery grid 4 columns auto height
 * Slug: sustainable-theme/gallery-grid-4-columns-auto-height
 * Categories: sustainable-theme,sustainable-theme/gallery
 * Description: Image grid gallery 4 columns auto height.
 * Keywords: gallery, grid, images, auto height
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-medium","bottom":"var:preset|spacing|fluid-medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--fluid-medium);padding-bottom:var(--wp--preset--spacing--fluid-medium)"><!-- wp:gallery {"columns":4,"imageCrop":false,"randomOrder":true,"linkTo":"none","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-small","left":"var:preset|spacing|fluid-small"}}}} -->
  <figure class="wp-block-gallery alignwide has-nested-images columns-4"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/northern-buttercups-flowers.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/red-hibiscus-closeup.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/botany-flowers.webp" alt="" /></figure>
    <!-- /wp:image -->

    <!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
    <figure class="wp-block-image size-large"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/delphinium-flowers.webp" alt="" /></figure>
    <!-- /wp:image -->
  </figure>
  <!-- /wp:gallery -->
</div>
<!-- /wp:group -->