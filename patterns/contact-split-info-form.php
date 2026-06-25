<?php

/**
 * Title: Contact split info and form
 * Slug: sustainable-theme/contact-split-info-form
 * Categories: sustainable-theme,sustainable-theme/contact,sustainable-theme/new
 * Description: Contact details on the left with a form placeholder on the right.
 * Keywords: contact, form, split, email, phone, address
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:columns {"align":"wide","verticalAlignment":"top","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-x-large","left":"var:preset|spacing|fluid-x-large"}}}} -->
  <div class="wp-block-columns alignwide are-vertically-aligned-top"><!-- wp:column {"width":"40%","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-large"}}} -->
    <div class="wp-block-column" style="flex-basis:40%"><!-- wp:heading {"className":"is-style-text-title"} -->
      <h2 class="wp-block-heading is-style-text-title">Let's talk</h2>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"fontSize":"md"} -->
      <p class="has-md-font-size">Fill out the form and we'll get back to you shortly. Prefer email? Reach us directly at the address below.</p>
      <!-- /wp:paragraph -->

      <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"constrained"}} -->
      <div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:icon {"icon":"core/envelope","style":{"dimensions":{"width":"24px"}},"ariaLabel":"Email icon"} /-->

          <!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
          <div class="wp-block-group"><!-- wp:paragraph {"fontSize":"sm","style":{"typography":{"fontWeight":"600"}}} -->
            <p class="has-sm-font-size" style="font-weight:600">Email</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"fontSize":"sm"} -->
            <p class="has-sm-font-size"><a href="mailto:hello@example.com">hello@example.com</a></p>
            <!-- /wp:paragraph -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:icon {"icon":"core/bell","style":{"dimensions":{"width":"24px"}},"ariaLabel":"Phone icon"} /-->

          <!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
          <div class="wp-block-group"><!-- wp:paragraph {"fontSize":"sm","style":{"typography":{"fontWeight":"600"}}} -->
            <p class="has-sm-font-size" style="font-weight:600">Phone</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"fontSize":"sm"} -->
            <p class="has-sm-font-size"><a href="tel:+31201234567">+31 20 123 4567</a></p>
            <!-- /wp:paragraph -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
        <div class="wp-block-group"><!-- wp:icon {"icon":"core/map-marker","style":{"dimensions":{"width":"24px"}},"ariaLabel":"Location icon"} /-->

          <!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
          <div class="wp-block-group"><!-- wp:paragraph {"fontSize":"sm","style":{"typography":{"fontWeight":"600"}}} -->
            <p class="has-sm-font-size" style="font-weight:600">Address</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"fontSize":"sm"} -->
            <p class="has-sm-font-size">12 Studio Lane<br>Amsterdam, NL</p>
            <!-- /wp:paragraph -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"width":"60%"} -->
    <div class="wp-block-column" style="flex-basis:60%"><!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-large","right":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-small"},"border":{"width":"1px"}},"backgroundColor":"neutral-1","layout":{"type":"constrained"}} -->
      <div class="wp-block-group has-neutral-1-background-color has-background" style="border-width:1px;padding-top:var(--wp--preset--spacing--fluid-large);padding-right:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large);padding-left:var(--wp--preset--spacing--fluid-large)"><!-- wp:heading {"level":3,"fontSize":"lg"} -->
        <h3 class="wp-block-heading has-lg-font-size">Send a message</h3>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"fontSize":"sm","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}}} -->
        <p class="has-sm-font-size"><em>Add your contact form here — insert a form block or shortcode from your preferred form plugin.</em></p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->