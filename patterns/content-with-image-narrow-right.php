<?php

/**
 * Title: Content with image narrow right
 * Slug: sustainable-theme/content-with-image-narrow-right
 * Categories: sustainable-theme,sustainable-theme/content
 * Description: A content section with an image on the right.
 * Keywords: content, content with image, text with image, image
 * Inserter: true
 */
?>
<!-- wp:group {"align":"full","className":"is-style-default","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-default" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:columns {"className":"is-style-default","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-medium","left":"var:preset|spacing|fluid-medium"}}}} -->
  <div class="wp-block-columns is-style-default">

    <!-- wp:column {"verticalAlignment":"center","width":"","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}}} -->
    <div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"className":"wp-block-heading is-style-subtitle"} -->
      <h2 class="wp-block-heading is-style-subtitle">About the book</h2>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"className":"is-style-default"} -->
      <p class="is-style-default">This exquisite compilation showcases a diverse array of photographs that capture the essence of different eras and cultures, reflecting the unique styles and perspectives of each artist. Fleckenstein’s evocative imagery, Strand’s groundbreaking modernist approach, and Kōno’s meticulous documentation of Japanese life come together in a harmonious blend that celebrates the art of photography.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"fontSize":"medium","layout":{"type":"flex","justifyContent":"left"}} -->
      <div class="wp-block-buttons has-custom-font-size has-medium-font-size" style="padding-top:0;padding-bottom:0"><!-- wp:button {"className":"is-style-fill"} -->
        <div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button">Read more</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column {"verticalAlignment":"center","width":"","layout":{"type":"default"}} -->
    <div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"id":220,"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
      <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-blue-light.webp" alt="" class="wp-image-220" style="aspect-ratio:1;object-fit:cover" /></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->