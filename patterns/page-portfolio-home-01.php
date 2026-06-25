<?php

/**
 * Title: Page Portfolio Home 01  (CLEAN UP)
 * Slug: sustainable-theme/page-portfolio-home-01
 * Categories: sustainable-theme,sustainable-theme/new,sustainable-theme/pages
 * Description: Portfolio home page layout with hero, stats, services, content, testimonials, and CTA.
 * Keywords: portfolio, portfolio home, portfolio page, portfolio landing
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"categories":["sustainable-theme","sustainable-theme/hero"],"patternName":"sustainable-theme/hero-simple-page-intro","name":"Hero simple page intro"},"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-medium","bottom":"var:preset|spacing|0"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--fluid-medium);padding-bottom:var(--wp--preset--spacing--0)"><!-- wp:heading {"level":1,"align":"wide","className":"is-style-text-title"} -->
  <h1 class="wp-block-heading alignwide is-style-text-title"><strong>Welcome to my portfolio</strong></h1>
  <!-- /wp:heading -->

  <!-- wp:paragraph {"align":"wide","fontSize":"lg"} -->
  <p class="alignwide has-lg-font-size">I partner with brands and cultural projects to tell sharper stories—through identity, editorial design, and thoughtful digital experiences.</p>
  <!-- /wp:paragraph -->

  <!-- wp:buttons {"align":"wide"} -->
  <div class="wp-block-buttons alignwide"><!-- wp:button -->
    <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Contact me</a></div>
    <!-- /wp:button -->

    <!-- wp:button {"className":"is-style-outline"} -->
    <div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Read more</a></div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"categories":["sustainable-theme/portfolio"],"patternName":"sustainable-theme/latest-posts-masonry","name":"Masonry Posts with tag filter"},"align":"wide","className":"sustainable-theme-post-grid sustainable-theme-posts-masonry","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-large","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide sustainable-theme-post-grid sustainable-theme-posts-masonry" style="padding-top:var(--wp--preset--spacing--fluid-large);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-small"},"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"left","verticalAlignment":"center"}} -->
  <div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-small)"><!-- wp:paragraph {"className":"is-style-default","style":{"layout":{"selfStretch":"fit","flexSize":null}},"fontSize":"sm"} -->
    <p class="is-style-default has-sm-font-size">Filter projects: </p>
    <!-- /wp:paragraph -->

    <!-- wp:tag-cloud {"numberOfTags":6,"smallestFontSize":"14.1px","largestFontSize":"14.1px","align":"right","className":"is-style-default","style":{"typography":{"textTransform":"uppercase","lineHeight":"1"},"spacing":{"padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"},"margin":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0"}}}} /-->
  </div>
  <!-- /wp:group -->

  <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
  <div class="wp-block-group alignfull" style="padding-top:0;padding-bottom:0"><!-- wp:query {"queryId":7,"query":{"perPage":12,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"align":"wide"} -->
    <div class="wp-block-query alignwide"><!-- wp:post-template {"className":"is-style-masonry","layout":{"type":"default"}} -->
      <!-- wp:group {"className":"sustainable-theme-masonry-item","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
      <div class="wp-block-group sustainable-theme-masonry-item" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"auto","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}}} /-->

        <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|fluid-x-small"}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"md"} /-->

        <!-- wp:post-excerpt {"moreText":"Read more","excerptLength":25,"style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"sm"} /-->
      </div>
      <!-- /wp:group -->
      <!-- /wp:post-template -->
    </div>
    <!-- /wp:query -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"categories":["sustainable-theme","sustainable-theme/cta"],"patternName":"sustainable-theme/cta-banner-centered","name":"CTA banner centered"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"backgroundColor":"secondary","textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-color has-secondary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:group {"layout":{"type":"constrained"}} -->
  <div class="wp-block-group"><!-- wp:heading {"className":"is-style-text-title","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"clamp(2rem, 4vw, 3rem)","textAlign":"center"}}} -->
    <h2 class="wp-block-heading has-text-align-center is-style-text-title has-text-color" style="color:#ffffff;font-size:clamp(2rem, 4vw, 3rem)">Shall we work together?</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-medium"}},"typography":{"textAlign":"center"}},"fontSize":"lg"} -->
    <p class="has-text-align-center has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small);margin-bottom:var(--wp--preset--spacing--fluid-medium)">Let's create something meaningful together. Get in touch and we'll take it from there.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"background","textColor":"foreground","className":"is-style-fill"} -->
      <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-foreground-color has-background-background-color has-text-color has-background wp-element-button">Contact me today</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->