<?php

/**
 * Title: Posts grid 2 columns manual
 * Slug: sustainable-theme/posts-grid-2-columns-manual
 * Categories: sustainable-theme,sustainable-theme/portfolio,sustainable-theme/posts,sustainable-theme/new
 * Description: A 2-column grid of manually curated project cards.
 * Keywords: posts, portfolio, blog, overview, grid, manual, projects
 * Inserter: true
 */

$projects = [
  [
    'image'  => sustainable_theme_placeholder_image('portfolio-1'),
    'title'  => 'Botanical identity system',
    'meta'   => 'Completed for Studio North, 2024',
    'label'  => 'Branding',
    'detail' => 'Identity and packaging',
  ],
  [
    'image'  => sustainable_theme_placeholder_image('portfolio-2'),
    'title'  => 'Field Notes editorial',
    'meta'   => 'Completed for Meadow Press, 2023',
    'label'  => 'Editorial',
    'detail' => 'Print layout and art direction',
  ],
  [
    'image'  => sustainable_theme_placeholder_image('portfolio-3'),
    'title'  => 'Coastal gallery website',
    'meta'   => 'Completed for Harbor Arts, 2024',
    'label'  => 'Web',
    'detail' => 'Design system and build',
  ],
  [
    'image'  => sustainable_theme_placeholder_image('portfolio-4'),
    'title'  => 'Seasonal campaign visuals',
    'meta'   => 'Completed for Lumen Co., 2023',
    'label'  => 'Campaign',
    'detail' => 'Photography direction',
  ],
  [
    'image'  => sustainable_theme_placeholder_image('portfolio-5'),
    'title'  => 'Nature reserve signage',
    'meta'   => 'Completed for Parks Trust, 2022',
    'label'  => 'Wayfinding',
    'detail' => 'Environmental graphics',
  ],
  [
    'image'  => sustainable_theme_placeholder_image('portfolio-6'),
    'title'  => 'Independent publisher catalogue',
    'meta'   => 'Completed for Page & Pine, 2024',
    'label'  => 'Publishing',
    'detail' => 'Cover series and typography',
  ],
];

?>
<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small"}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"16rem"}} -->
  <div class="wp-block-group alignwide">
    <?php foreach ($projects as $project) : ?>
      <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small","padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"constrained"}} -->
      <div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:image {"aspectRatio":"16/9","scale":"cover","sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":{"topLeft":"15px","topRight":"15px","bottomLeft":"15px","bottomRight":"15px"}}}} -->
        <figure class="wp-block-image size-large has-custom-border"><img src="<?php echo esc_url($project['image']); ?>" alt="" style="border-top-left-radius:15px;border-top-right-radius:15px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;aspect-ratio:16/9;object-fit:cover" /></figure>
        <!-- /wp:image -->

        <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|fluid-small","padding":{"top":"var:preset|spacing|0","bottom":"var:preset|spacing|0","left":"var:preset|spacing|0","right":"var:preset|spacing|0"}}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"12rem"}} -->
        <div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--0);padding-right:var(--wp--preset--spacing--0);padding-bottom:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)"><!-- wp:group {"layout":{"type":"constrained","justifyContent":"left"}} -->
          <div class="wp-block-group"><!-- wp:heading {"level":3,"className":"is-style-default","fontSize":"md"} -->
            <h3 class="wp-block-heading is-style-default has-md-font-size"><strong><?php echo esc_html($project['title']); ?></strong></h3>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"fontSize":"sm"} -->
            <p class="has-sm-font-size"><?php echo esc_html($project['meta']); ?></p>
            <!-- /wp:paragraph -->
          </div>
          <!-- /wp:group -->

          <!-- wp:group {"layout":{"type":"constrained","justifyContent":"left"}} -->
          <div class="wp-block-group"><!-- wp:paragraph {"fontSize":"sm"} -->
            <p class="has-sm-font-size"><strong><?php echo esc_html($project['label']); ?></strong></p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"fontSize":"sm"} -->
            <p class="has-sm-font-size"><?php echo esc_html($project['detail']); ?></p>
            <!-- /wp:paragraph -->
          </div>
          <!-- /wp:group -->
        </div>
        <!-- /wp:group -->
      </div>
      <!-- /wp:group -->
    <?php endforeach; ?>
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->