<?php

/**
 * Title: Page about 3
 * Slug: sustainable-theme/page-about-3
 * Categories: sustainable-theme,sustainable-theme/content,sustainable-theme/pages,sustainable-theme/new
 * Description: Full about page with intro, editorial story, image sections, big number, quote, and CTA.
 * Keywords: about, page, editorial, image, story, landscape, history
 * Inserter: true
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-medium"},"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-medium)"><!-- wp:heading {"level":1,"className":"is-style-text-title"} -->
  <h1 class="wp-block-heading is-style-text-title">About us</h1>
  <!-- /wp:heading -->

  <!-- wp:paragraph {"fontSize":"lg"} -->
  <p class="has-lg-font-size">A studio shaped by curiosity, craft, and a belief that good design should feel inevitable — as if it could not have been any other way.</p>
  <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-large","padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignwide"><!-- wp:heading {"className":"is-style-subtitle"} -->
    <h2 class="wp-block-heading is-style-subtitle">Our history</h2>
    <!-- /wp:heading -->

    <!-- wp:heading {"className":"is-style-text-title"} -->
    <h2 class="wp-block-heading is-style-text-title">A studio shaped by curiosity</h2>
    <!-- /wp:heading -->

    <!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-medium","left":"var:preset|spacing|fluid-large"}}}} -->
    <div class="wp-block-columns alignwide"><!-- wp:column {"width":"40%"} -->
      <div class="wp-block-column" style="flex-basis:40%"><!-- wp:paragraph {"fontSize":"lg"} -->
        <p class="has-lg-font-size">We make things that feel inevitable — as if they could not have been any other way.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->

      <!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}}} -->
      <div class="wp-block-column"><!-- wp:paragraph {"fontSize":"md"} -->
        <p class="has-md-font-size">Founded in 2018, we began as a two-person operation working from a shared studio in the city. Since then we have grown carefully, always prioritising the quality of our work over the volume of projects we take on.</p>
        <!-- /wp:paragraph -->

        <!-- wp:paragraph {"fontSize":"md"} -->
        <p class="has-md-font-size">Today we work with clients across a range of industries — from independent makers and cultural institutions to established brands ready for their next chapter. What we share with all of them is an honest commitment to doing the work well.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
  </div>
  <!-- /wp:group -->

  <!-- wp:image {"align":"wide","aspectRatio":"16/9","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
  <figure class="wp-block-image alignwide size-full"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/botany-flowers.webp" alt="" style="aspect-ratio:16/9;object-fit:cover" /></figure>
  <!-- /wp:image -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"sustainable-theme/content-with-image-left"} /-->

<!-- wp:pattern {"slug":"sustainable-theme/content-big-number"} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"backgroundColor":"neutral-1","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-neutral-1-background-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-large"}}}} -->
  <div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"top","width":"30%"} -->
    <div class="wp-block-column is-vertically-aligned-top" style="flex-basis:30%"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"clamp(5rem, 15vw, 12rem)","fontWeight":"700","lineHeight":"0.9"}}} -->
      <p class="has-text-align-center" style="font-size:clamp(5rem, 15vw, 12rem);font-weight:700;line-height:0.9">02</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"width":"70%","verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}}} -->
    <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70%"><!-- wp:heading {"level":2,"fontSize":"xl"} -->
      <h2 class="wp-block-heading has-xl-font-size">We design with intention</h2>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"fontSize":"lg"} -->
      <p class="has-lg-font-size">Every choice we make — from typography to colour to layout — serves a purpose. We strip away what is unnecessary and focus on what helps your message land clearly and confidently.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"sustainable-theme/content-quote"} /-->

<!-- wp:pattern {"slug":"sustainable-theme/cta-banner-centered"} /-->
