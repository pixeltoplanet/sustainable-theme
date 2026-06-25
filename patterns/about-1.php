<?php

/**
 * Title: About 1
 * Slug: sustainable-theme/about-1
 * Categories: sustainable-theme,sustainable-theme/content,sustainable-theme/new
 * Description: About section with a portrait image and intro text side by side.
 * Keywords: about, image, intro, portrait, team
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"backgroundColor":"neutral-1","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-neutral-1-background-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-large"}}}} -->
  <div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"40%"} -->
    <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%"><!-- wp:image {"aspectRatio":"3/4","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":{"topLeft":"var(--rounded-image)","topRight":"var(--rounded-image)","bottomLeft":"var(--rounded-image)","bottomRight":"var(--rounded-image)"}}}} -->
      <figure class="wp-block-image size-full has-custom-border"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/botany-flowers-closeup.webp" alt="" style="border-top-left-radius:var(--rounded-image);border-top-right-radius:var(--rounded-image);border-bottom-left-radius:var(--rounded-image);border-bottom-right-radius:var(--rounded-image);aspect-ratio:3/4;object-fit:cover" /></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-medium"}}} -->
    <div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading {"className":"is-style-text-title"} -->
      <h2 class="wp-block-heading is-style-text-title">We believe in work that matters</h2>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"fontSize":"md"} -->
      <p class="has-md-font-size">We are a small studio working at the intersection of design, strategy, and craft. Every project we take on is an opportunity to make something that holds up over time — honest, considered, and built to last.</p>
      <!-- /wp:paragraph -->

      <!-- wp:paragraph {"fontSize":"md"} -->
      <p class="has-md-font-size">We work closely with founders, independent makers, and organisations who care about quality as much as we do.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
      <div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"tertiary","textColor":"background","className":"is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}}} -->
        <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-background-color has-tertiary-background-color has-text-color has-background has-link-color wp-element-button">Our story</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->
