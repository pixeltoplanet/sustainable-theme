<?php

/**
 * Title: Hero asymmetric
 * Slug: sustainable-theme/hero-asymmetric
 * Categories: sustainable-theme,sustainable-theme/hero
 * Description: Asymmetric hero with offset image and bold typography.
 * Keywords: hero, asymmetric, offset, editorial
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","className":"sustainable-theme-hero-asymmetric","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull sustainable-theme-hero-asymmetric" style="padding-top:0;padding-bottom:0"><!-- wp:columns {"align":"full","style":{"spacing":{"blockGap":{"top":"0","left":"0"}}}} -->
  <div class="wp-block-columns alignfull"><!-- wp:column {"verticalAlignment":"center","width":"64%","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-large","right":"var:preset|spacing|fluid-large"}}}} -->
    <div class="wp-block-column is-vertically-aligned-center" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-right:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large);padding-left:var(--wp--preset--spacing--fluid-large);flex-basis:64%"><!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem","fontWeight":"400","letterSpacing":"0.3em","fontStyle":"normal","textTransform":"uppercase"},"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}},"textColor":"neutral-2"} -->
      <p class="has-neutral-2-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--fluid-x-small);font-size:0.9rem;font-style:normal;font-weight:400;letter-spacing:0.3em;text-transform:uppercase">Creative studio</p>
      <!-- /wp:paragraph -->

      <!-- wp:heading {"level":1,"className":"is-style-text-title"} -->
      <h1 class="wp-block-heading is-style-text-title">We design digital experiences that move people.</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}},"elements":{"link":{"color":{"text":"var:preset|color|neutral-2"}}}},"textColor":"neutral-2","fontSize":"lg"} -->
      <p class="has-neutral-2-color has-text-color has-link-color has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small)">Strategy, design, and development.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"stretch","width":"41.67%","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
    <div class="wp-block-column is-vertically-aligned-stretch" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;flex-basis:41.67%"><!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp","dimRatio":0,"minHeight":100,"minHeightUnit":"%","contentPosition":"center center","align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
      <div class="wp-block-cover alignfull" style="padding-top:0;padding-bottom:0;min-height:100%"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
        <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1px"}}} -->
          <p class="has-text-align-center" style="font-size:1px"></p>
          <!-- /wp:paragraph -->
        </div>
      </div>
      <!-- /wp:cover -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->