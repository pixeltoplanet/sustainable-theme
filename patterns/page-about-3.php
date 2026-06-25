<?php

/**
 * Title: Page about 3
 * Slug: sustainable-theme/page-about-3
 * Categories: sustainable-theme,sustainable-theme/content,sustainable-theme/pages,sustainable-theme/new
 * Description: Full about page with editorial heading, two-column text, full-width image, and CTA.
 * Keywords: about, page, editorial, image, story, landscape
 * Inserter: true
 */

?>
<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-medium","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--fluid-medium);padding-bottom:var(--wp--preset--spacing--0)"><!-- wp:heading {"level":1,"className":"is-style-text-title"} -->
  <h1 class="wp-block-heading is-style-text-title">About us</h1>
  <!-- /wp:heading -->
</div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-large","padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-medium"}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignwide"><!-- wp:heading {"className":"is-style-text-title"} -->
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

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"backgroundColor":"secondary","textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-color has-secondary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:group {"layout":{"type":"constrained"}} -->
  <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","className":"is-style-text-title","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"clamp(2rem, 4vw, 3rem)"}}} -->
    <h2 class="wp-block-heading has-text-align-center is-style-text-title has-text-color" style="color:#ffffff;font-size:clamp(2rem, 4vw, 3rem)">Let's work together</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-medium"}}},"fontSize":"lg"} -->
    <p class="has-text-align-center has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small);margin-bottom:var(--wp--preset--spacing--fluid-medium)">We'd love to hear about your project. Reach out and let's start a conversation.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"background","textColor":"foreground","className":"is-style-fill"} -->
      <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-foreground-color has-background-background-color has-text-color has-background wp-element-button">Get in touch</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
