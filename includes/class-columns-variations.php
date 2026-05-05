<?php

namespace SustainableTheme;

/**
 * Adds extra layout variations to the core/columns block.
 *
 * Registers 4 / 5 / 6 column presets (equal + a few asymmetric) as items in
 * the regular block inserter — not in the Columns placeholder picker. The
 * placeholder picker has a fixed grid that becomes cramped past ~6 entries
 * and would need custom SVG icons (which require shipping JS) to look right.
 *
 * Using scope = ['inserter'] keeps the picker clean while still making the
 * presets discoverable: users can search "4 columns" / "20" etc. and the
 * inserter shows a live preview of the column layout on hover.
 *
 * Implemented via the get_block_type_variations filter so no extra JS bundle
 * is needed in the editor — keeping us inside Theme Directory rules.
 */
class ColumnsVariations
{
  public function __construct()
  {
    add_filter('get_block_type_variations', [$this, 'register_variations'], 10, 2);
  }

  /**
   * Append extra Columns variations to the block-scoped picker.
   *
   * @param array          $variations Existing variations.
   * @param \WP_Block_Type $block_type Block type being filtered.
   * @return array
   */
  public function register_variations(array $variations, \WP_Block_Type $block_type): array
  {
    if ($block_type->name !== 'core/columns') {
      return $variations;
    }

    $extra = [
      // Equal-width presets.
      [
        'name'        => 'sustainable-theme/four-columns-equal',
        'title'       => __('4 columns: 25 / 25 / 25 / 25', 'sustainable-theme'),
        'description' => __('Four equal columns.', 'sustainable-theme'),
        'keywords'    => ['columns', '4', 'four', 'grid', 'quarters'],
        'scope'       => ['inserter'],
        'attributes'  => ['className' => 'has-4-columns'],
        'innerBlocks' => $this->equal_columns(4, '25%'),
      ],
      [
        'name'        => 'sustainable-theme/five-columns-equal',
        'title'       => __('5 columns: 20 / 20 / 20 / 20 / 20', 'sustainable-theme'),
        'description' => __('Five equal columns.', 'sustainable-theme'),
        'keywords'    => ['columns', '5', 'five', 'grid', 'fifths'],
        'scope'       => ['inserter'],
        'attributes'  => ['className' => 'has-5-columns'],
        'innerBlocks' => $this->equal_columns(5, '20%'),
      ],
      [
        'name'        => 'sustainable-theme/six-columns-equal',
        'title'       => __('6 columns (equal)', 'sustainable-theme'),
        'description' => __('Six equal columns.', 'sustainable-theme'),
        'keywords'    => ['columns', '6', 'six', 'grid', 'sixths'],
        'scope'       => ['inserter'],
        'attributes'  => ['className' => 'has-6-columns'],
        'innerBlocks' => $this->equal_columns(6, '16.66%'),
      ],

      // Asymmetric presets — useful for feature/sidebar layouts.
      [
        'name'        => 'sustainable-theme/four-columns-feature-left',
        'title'       => __('4 columns: 40 / 20 / 20 / 20', 'sustainable-theme'),
        'description' => __('Wider feature column on the left, three equal on the right.', 'sustainable-theme'),
        'keywords'    => ['columns', '4', 'feature', 'asymmetric'],
        'scope'       => ['inserter'],
        'attributes'  => ['className' => 'has-4-columns'],
        'innerBlocks' => [
          ['core/column', ['width' => '40%']],
          ['core/column', ['width' => '20%']],
          ['core/column', ['width' => '20%']],
          ['core/column', ['width' => '20%']],
        ],
      ],
      [
        'name'        => 'sustainable-theme/four-columns-feature-right',
        'title'       => __('4 columns: 20 / 20 / 20 / 40', 'sustainable-theme'),
        'description' => __('Three equal columns on the left, wider feature column on the right.', 'sustainable-theme'),
        'keywords'    => ['columns', '4', 'feature', 'asymmetric'],
        'scope'       => ['inserter'],
        'attributes'  => ['className' => 'has-4-columns'],
        'innerBlocks' => [
          ['core/column', ['width' => '20%']],
          ['core/column', ['width' => '20%']],
          ['core/column', ['width' => '20%']],
          ['core/column', ['width' => '40%']],
        ],
      ],
    ];

    return array_merge($variations, $extra);
  }

  /**
   * Helper: build N equal-width core/column inner blocks.
   *
   * @param int    $count Number of columns.
   * @param string $width CSS width value (e.g. "25%").
   * @return array
   */
  private function equal_columns(int $count, string $width): array
  {
    return array_fill(0, $count, ['core/column', ['width' => $width]]);
  }
}
