<?php

/**
 * Title: CTA banner centered
 * Slug: sustainable-theme/cta-banner-centered
 * Categories: sustainable-theme,sustainable-theme/cta
 * Description: A centered CTA banner with a bold title and a paragraph.
 * Keywords: cta, banner, centered, bold, title, paragraph
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"backgroundColor":"secondary","textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-color has-secondary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)">
  <!-- wp:group {"layout":{"type":"constrained"}} -->
  <div class="wp-block-group">
    <!-- wp:heading {"textAlign":"center","className":"is-style-text-title","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"clamp(2rem, 4vw, 3rem)"}}} -->
    <h2 class="wp-block-heading has-text-align-center is-style-text-title has-text-color" style="color:#ffffff;font-size:clamp(2rem, 4vw, 3rem)">Ready to start your project?</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-medium"}}},"fontSize":"lg"} -->
    <p class="has-text-align-center has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small);margin-bottom:var(--wp--preset--spacing--fluid-medium)">Let's create something meaningful together. Get in touch and we'll take it from there.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"background","textColor":"foreground","className":"is-style-fill"} -->
      <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-foreground-color has-background-background-color has-text-color has-background wp-element-button">Contact us today</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->