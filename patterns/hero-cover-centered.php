<?php

/**
 * Title: Hero cover boxed centered
 * Slug: sustainable-theme/hero-cover-centered
 * Categories: sustainable-theme,sustainable-theme/hero
 * Description: A centered hero with background image and overlay.
 * Keywords: hero, cover, centered, background image, header
 * Inserter: true
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)">
  <!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange.webp","dimRatio":40,"overlayColor":"foreground","isUserOverlayColor":true,"minHeight":50,"minHeightUnit":"vh","contentPosition":"center center","isDark":false,"sizeSlug":"full","align":"wide","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}},"heading":{"color":{"text":"var:preset|color|background"}}},"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"textColor":"background","layout":{"type":"constrained"}} -->
  <div class="wp-block-cover alignwide is-light has-background-color has-background-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large);min-height:50vh">
    <span aria-hidden="true" class="wp-block-cover__background has-foreground-background-color has-background-dim-40 has-background-dim"></span>
    <img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/color-orange.webp" data-object-fit="cover" />
    <div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
      <div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"center","level":1,"className":"is-style-text-title"} -->
        <h1 class="wp-block-heading has-text-align-center is-style-text-title">Welcome to our portfolio</h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}}},"fontSize":"lg"} -->
        <p class="has-text-align-center has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small)">Ad consequat enim sit quis eu laborum duis est. Aliqua magna officia ipsum sunt aliquip veniam enim ea aliquip aute eiusmod aute. Ex nulla laborum sint reprehenderit amet.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->

      <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-medium"}}}} -->
      <div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--fluid-medium)"><!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Read more</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
  </div>
  <!-- /wp:cover -->
</div>
<!-- /wp:group -->