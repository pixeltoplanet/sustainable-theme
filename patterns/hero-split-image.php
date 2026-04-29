<?php

/**
 * Title: Hero split with image
 * Slug: sustainable-theme/hero-split-image
 * Categories: sustainable-theme,sustainable-theme/hero
 * Description: A hero with split layout—image on one side, text on the other.
 * Keywords: hero, split, image, layout
 * Inserter: true
 */

?>
<!-- wp:columns {"align":"full","style":{"spacing":{"blockGap":{"top":"0","left":"0"},"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"backgroundColor":"background","layout":{"type":"default"}} -->
<div class="wp-block-columns alignfull has-background-background-color has-background" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:column {"verticalAlignment":"center","width":"50%","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large","left":"var:preset|spacing|fluid-x-large","right":"var:preset|spacing|fluid-x-large"}}}} -->
  <div class="wp-block-column is-vertically-aligned-center" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-right:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large);padding-left:var(--wp--preset--spacing--fluid-x-large);flex-basis:50%"><!-- wp:heading {"level":1,"className":"is-style-text-title"} -->
    <h1 class="wp-block-heading is-style-text-title">Crafting experiences that resonate</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}}},"fontSize":"lg"} -->
    <p class="has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small)">We believe in the power of thoughtful design to transform ideas into meaningful connections. Every project begins with curiosity and ends with something that feels both new and familiar.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-medium"},"blockGap":{"top":"var:preset|spacing|fluid-small","left":"var:preset|spacing|fluid-small"}}}} -->
    <div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--fluid-medium)"><!-- wp:button -->
      <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Get started</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"className":"is-style-outline"} -->
      <div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Learn more</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:column -->

  <!-- wp:column {"verticalAlignment":"stretch","width":"50%","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
  <div class="wp-block-column is-vertically-aligned-stretch" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;flex-basis:50%"><!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp","dimRatio":0,"minHeight":60,"minHeightUnit":"vh","contentPosition":"center center","isDark":false,"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
    <div class="wp-block-cover alignfull is-light" style="padding-top:0;padding-bottom:0;min-height:60vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
      <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1px"}},"textColor":"background"} -->
        <p class="has-text-align-center has-background-color has-text-color" style="font-size:1px"></p>
        <!-- /wp:paragraph -->
      </div>
    </div>
    <!-- /wp:cover -->
  </div>
  <!-- /wp:column -->
</div>
<!-- /wp:columns -->