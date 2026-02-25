<?php

/**
 * Title: Content with image vertical
 * Slug: sustainable-theme/content-with-image-vertical
 * Categories: sustainable-theme,sustainable-theme/content
 * Description: A content section with an image below the text.
 * Keywords: content, content with image, text with image, image
 * Inserter: true
 */
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small","padding":{"top":"var:preset|spacing|fluid-medium","bottom":"var:preset|spacing|fluid-medium"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--fluid-medium);padding-bottom:var(--wp--preset--spacing--fluid-medium)"><!-- wp:heading {"className":"is-style-subtitle"} -->
  <h2 class="wp-block-heading is-style-subtitle">Making work that holds up</h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph {"fontSize":"lg"} -->
  <p class="has-lg-font-size">I spend most of my time in the space between idea and outcome. The best projects start with curiosity and end with something that feels both new and familiar. I’m drawn to work that stays clear and honest, and I try to bring that into everything I do.</p>
  <!-- /wp:paragraph -->

  <!-- wp:image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
  <figure class="wp-block-image size-full"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/northern-buttercups-flowers.webp" alt="" class="" style="aspect-ratio:16/9;object-fit:cover" /></figure>
  <!-- /wp:image -->
</div>
<!-- /wp:group -->