<?php

/**
 * Title: Hero bent
 * Slug: sustainable-theme/hero-bent
 * Categories: sustainable-theme,sustainable-theme/hero
 * Description: Hero with bent/angled bottom edge and overlay.
 * Keywords: hero, bent, angled, shape
 * Inserter: true
 */

?>
<!-- wp:group { "className":"alignfull sustainable-hero-bent"} -->
<div class="wp-block-group alignfull sustainable-hero-bent"><!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp","dimRatio":50,"overlayColor":"foreground","isUserOverlayColor":true,"minHeight":65,"minHeightUnit":"vh","contentPosition":"center center","align":"full","className":"is-dark has-link-color","style":{"border":{"radius":"0 0 8rem 8rem"},"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"textColor":"background","layout":{"type":"constrained"}} -->
  <div class="wp-block-cover alignfull is-dark has-link-color has-background-color has-text-color" style="border-radius:0 0 8rem 8rem;padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large);min-height:65vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-foreground-background-color has-background-dim"></span>
    <div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":1,"className":"is-style-text-title","style":{"typography":{"fontSize":"clamp(2.5rem, 6vw, 5rem)"}}} -->
      <h1 class="wp-block-heading has-text-align-center is-style-text-title" style="font-size:clamp(2.5rem, 6vw, 5rem)">Create. Iterate. Ship.</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}}},"fontSize":"lg"} -->
      <p class="has-text-align-center has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small)">A design-led approach to building products that resonate.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-medium"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
      <div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--fluid-medium)"><!-- wp:button {"backgroundColor":"tertiary","textColor":"foreground"} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-foreground-color has-tertiary-background-color has-text-color has-background wp-element-button">Start a project</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
  </div>
  <!-- /wp:cover -->
</div>
<!-- /wp:group -->