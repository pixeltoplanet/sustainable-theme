<?php

/**
 * Title: Page post overview 2
 * Slug: sustainable-theme/page-post-overview-2
 * Categories: sustainable-theme,sustainable-theme/posts,sustainable-theme/pages,sustainable-theme/new
 * Description: Full blog index page with a large featured post and secondary 3-column grid.
 * Keywords: posts, blog, overview, page, featured, grid
 * Inserter: true
 */

?>
<!-- wp:group {"metadata":{"categories":["sustainable-theme","sustainable-theme/hero"],"name":"Hero cover boxed"},"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-small"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-small)"><!-- wp:cover {"url":"http://pixeltoplanet.local/wp-content/themes/sustainable-theme/assets/images/hero-podcast.webp","dimRatio":0,"isUserOverlayColor":true,"minHeight":50,"minHeightUnit":"vh","contentPosition":"center center","isDark":false,"sizeSlug":"full","align":"wide","className":"has-background-color sustainable-theme-hero-cover-boxed","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}},"heading":{"color":{"text":"var:preset|color|background"}}},"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"textColor":"background","layout":{"type":"constrained"}} -->
  <div class="wp-block-cover alignwide is-light has-background-color sustainable-theme-hero-cover-boxed has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large);min-height:50vh"><img class="wp-block-cover__image-background size-full" alt="" src="http://pixeltoplanet.local/wp-content/themes/sustainable-theme/assets/images/hero-podcast.webp" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
    <div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
      <div class="wp-block-group alignwide"><!-- wp:heading {"level":1,"className":"is-style-text-title","style":{"typography":{"textAlign":"left"}}} -->
        <h1 class="wp-block-heading has-text-align-left is-style-text-title">Welcome to our portfolio</h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}},"typography":{"textAlign":"left"}},"fontSize":"lg"} -->
        <p class="has-text-align-left has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small)">Ad consequat enim sit quis eu laborum duis est. Aliqua magna officia ipsum sunt aliquip veniam enim ea aliquip aute eiusmod aute. Ex nulla laborum sint reprehenderit amet.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->

      <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-medium"}}}} -->
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

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-large"},"blockGap":"var:preset|spacing|fluid-large"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--fluid-small);padding-bottom:var(--wp--preset--spacing--fluid-large)"><!-- wp:query {"queryId":6,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"include","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
  <div class="wp-block-query alignwide"><!-- wp:post-template {"layout":{"type":"default"}} -->
    <!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|fluid-large","left":"var:preset|spacing|fluid-large"}}}} -->
    <div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
      <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","style":{"border":{"radius":{"topLeft":"var(\u002d\u002drounded-image)","topRight":"var(\u002d\u002drounded-image)","bottomLeft":"var(\u002d\u002drounded-image)","bottomRight":"var(\u002d\u002drounded-image)"}}}} /--></div>
      <!-- /wp:column -->

      <!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}}} -->
      <div class="wp-block-column is-vertically-aligned-center"><!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|fluid-x-small"}}},"fontSize":"xs"} /-->

        <!-- wp:post-title {"isLink":true,"style":{"typography":{"fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|fluid-x-small"}}},"fontSize":"xl"} /-->

        <!-- wp:post-excerpt {"moreText":"","excerptLength":30,"style":{"spacing":{"margin":{"top":"0"}}},"fontSize":"md"} /-->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
        <div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"tertiary","textColor":"background","className":"is-style-fill","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}}} -->
          <div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-background-color has-tertiary-background-color has-text-color has-background has-link-color wp-element-button">Read more</a></div>
          <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
      </div>
      <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->

  <!-- wp:query {"queryId":7,"query":{"perPage":24,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false,"sustainable_exclude_current":true},"align":"wide"} -->
  <div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"14rem"}} -->
    <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-x-small","padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-group" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1"} /-->

      <!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-x-small"}}},"fontSize":"xs"} /-->

      <!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0"}},"typography":{"fontStyle":"normal","fontWeight":"600"}},"fontSize":"sm"} /-->
    </div>
    <!-- /wp:group -->
    <!-- /wp:post-template -->
  </div>
  <!-- /wp:query -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"backgroundColor":"secondary","textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-background-color has-secondary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large)"><!-- wp:group {"layout":{"type":"constrained"}} -->
  <div class="wp-block-group"><!-- wp:heading {"className":"is-style-text-title","style":{"color":{"text":"#ffffff"},"typography":{"fontSize":"clamp(2rem, 4vw, 3rem)","textAlign":"center"}}} -->
    <h2 class="wp-block-heading has-text-align-center is-style-text-title has-text-color" style="color:#ffffff;font-size:clamp(2rem, 4vw, 3rem)">Want to work together?</h2>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small","bottom":"var:preset|spacing|fluid-medium"}},"typography":{"textAlign":"center"}},"fontSize":"lg"} -->
    <p class="has-text-align-center has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small);margin-bottom:var(--wp--preset--spacing--fluid-medium)">Let's create something meaningful together. Get in touch and we'll take it from there.</p>
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