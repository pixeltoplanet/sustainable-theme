<?php

/**
 * Title: Navigation — Main Menu
 * Slug: sustainable-theme/navigation
 * Categories: sustainable-theme,sustainable-theme/header
 * Description: The theme's shared Main Menu navigation, seeded with Home, About, Latest Work, and Contact links.
 * Keywords: navigation, menu, links, main menu
 * Inserter: true
 */
?>
<?php echo sustainable_theme_navigation([
  'overlayBackgroundColor' => 'background',
  'overlayTextColor'       => 'foreground',
  'style'                  => [
    'spacing' => ['blockGap' => 'var:preset|spacing|fluid-small'],
    'layout'  => ['selfStretch' => 'fit', 'flexSize' => null],
  ],
  'fontSize'               => 'sm',
  'layout'                 => [
    'type'                   => 'flex',
    'setCascadingProperties' => true,
    'justifyContent'         => 'right',
  ],
]); ?>
