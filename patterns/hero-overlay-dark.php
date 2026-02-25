<?php

/**
 * Title: Hero overlay dark
 * Slug: sustainable-theme/hero-overlay-dark
 * Categories: sustainable-theme,sustainable-theme/hero
 * Description: A full-bleed hero with dark overlay and centered white text.
 * Keywords: hero, overlay, dark, full bleed
 * Inserter: true
 */

?>
<!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp","dimRatio":70,"overlayColor":"foreground","isUserOverlayColor":true,"minHeight":80,"minHeightUnit":"vh","contentPosition":"center center","isDark":true,"align":"full","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}},"heading":{"color":{"text":"var:preset|color|background"}}},"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|fluid-x-large","bottom":"var:preset|spacing|fluid-x-large"}}},"textColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull is-dark has-background-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--fluid-x-large);padding-bottom:var(--wp--preset--spacing--fluid-x-large);min-height:80vh"><span aria-hidden="true" class="wp-block-cover__background has-foreground-background-color has-background-dim-70 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/coming-soon-bg-image.webp" data-object-fit="cover" /><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"center","level":1,"className":"is-style-text-title"} -->
<h1 class="wp-block-heading has-text-align-center is-style-text-title">Where creativity meets craft</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-small"}}},"fontSize":"lg"} -->
<p class="has-text-align-center has-lg-font-size" style="margin-top:var(--wp--preset--spacing--fluid-small)">We create digital experiences that inspire, engage, and endure. Every pixel placed with purpose, every interaction designed to delight.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|fluid-medium"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--fluid-medium)"><!-- wp:button {"backgroundColor":"background","textColor":"foreground"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-foreground-color has-background-background-color has-text-color has-background wp-element-button">Explore our portfolio</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div></div>
<!-- /wp:cover -->
