<?php

/**
 * Title: Hero cover bottom
 * Slug: sustainable-theme/hero-cover-bottom
 * Categories: sustainable-theme,sustainable-theme/hero
 * Description: A hero with background image and overlay at the bottom of the page.
 * Keywords: hero, cover, background image, header
 * Inserter: true
 */

?>
<!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/northern-buttercups-flowers.webp","dimRatio":0,"isUserOverlayColor":true,"minHeight":70,"minHeightUnit":"vh","contentPosition":"bottom left","isDark":false,"sizeSlug":"full","align":"full","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}},"heading":{"color":{"text":"var:preset|color|background"}}},"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|60"}}},"textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull is-light has-custom-content-position is-position-bottom-left has-background-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--60);min-height:70vh"><img class="wp-block-cover__image-background size-full" alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/northern-buttercups-flowers.webp" data-object-fit="cover" /><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
  <div class="wp-block-cover__inner-container"><!-- wp:group {"align":"full","layout":{"type":"constrained"}} -->
    <div class="wp-block-group alignfull"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
      <div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"left","level":1,"className":"is-style-text-title"} -->
        <h1 class="wp-block-heading has-text-align-left is-style-text-title">Where passion meets design</h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"left","style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}}},"fontSize":"md"} -->
        <p class="has-text-align-left has-md-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small)">Ad consequat enim sit quis eu laborum duis est. Aliqua magna officia ipsum sunt aliquip veniam enim ea aliquip aute eiusmod aute. Ex nulla laborum sint reprehenderit amet.</p>
        <!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:group -->
  </div>
</div>
<!-- /wp:cover -->