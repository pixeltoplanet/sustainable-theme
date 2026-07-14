<?php

namespace SustainableTheme;

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Style Wizard — persists design tokens chosen via the interactive wizard
 * and outputs them as CSS custom properties + theme.json integration.
 */
class StyleWizard
{
  public const OPTION = 'sustainable_theme_style_wizard';

  public function __construct()
  {
    add_action('rest_api_init', [$this, 'register_routes']);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_css_variables'], 20);
    add_action('enqueue_block_assets', [$this, 'enqueue_css_variables'], 20);
    add_action('wp_footer', [$this, 'print_animation_script'], 99);
    add_filter('wp_theme_json_data_theme', [$this, 'filter_theme_json'], 20);
  }

  public static function get_defaults(): array
  {
    return [
      'wizard_completed' => false,

      // Visual identity preset (starting point)
      'identity' => 'custom', // minimal | modern | editorial | brutalist | organic | custom

      // Color palette
      'palette_id' => 'earth',
      'color_primary' => '#2d6a4f',
      'color_secondary' => '#40916c',
      'color_accent' => '#95d5b2',
      'color_background' => '#ffffff',
      'color_surface' => '#f8faf9',
      'color_text' => '#1b1b1b',
      'color_text_muted' => '#6b7280',

      // Typography
      'font_heading' => 'system-ui',
      'font_body' => 'system-ui',
      'type_scale' => 'minor-third', // minor-third | major-third | perfect-fourth | augmented-fourth
      'heading_weight' => 'bold', // light | normal | bold | black
      'heading_transform' => 'none', // none | uppercase | lowercase
      'heading_letter_spacing' => 'normal', // tight | normal | wide | extra-wide
      'body_line_height' => 'normal', // tight | normal | relaxed | loose

      // Spacing & rhythm
      'spacing_scale' => 'comfortable', // dense | compact | comfortable | spacious | editorial
      'section_gap' => '80px',
      'content_width' => 'default', // narrow | default | wide | full-bleed
      'vertical_rhythm' => 'balanced', // tight | balanced | dramatic

      // Layout preferences
      'hero_style' => 'full-cover', // full-cover | boxed | split-image | minimal-text | oversized-type
      'content_layout' => 'mixed', // text-first | image-beside | mixed | card-grid | stacked-full

      // Shapes & borders
      'border_radius' => 'soft', // none | subtle | soft | rounded | pill
      'shadow_style' => 'subtle', // none | subtle | medium | dramatic
      'border_style' => 'none', // none | subtle | strong | brutalist

      // Animation preferences
      'animation_style' => 'subtle', // none | subtle | playful | dramatic | glitch
      'animation_trigger' => 'scroll', // load | scroll | hover | combined
      'animation_speed' => 'normal', // slow | normal | fast
    ];
  }

  public function get_settings(): array
  {
    $stored = get_option(self::OPTION, []);
    if (!is_array($stored)) {
      $stored = [];
    }
    return array_merge(self::get_defaults(), $stored);
  }

  public function sanitize_settings(array $input): array
  {
    $defaults = self::get_defaults();
    $sanitized = [];

    foreach ($defaults as $key => $default) {
      if ($key === 'wizard_completed') {
        $sanitized[$key] = !empty($input[$key]);
        continue;
      }

      $value = $input[$key] ?? $default;

      if (str_starts_with($key, 'color_')) {
        $sanitized[$key] = sanitize_hex_color((string) $value) ?: $default;
      } else {
        $sanitized[$key] = sanitize_text_field((string) $value);
      }
    }

    return $sanitized;
  }

  public function register_routes(): void
  {
    register_rest_route('sustainable-theme/v1', '/style-wizard', [
      [
        'methods' => 'GET',
        'callback' => [$this, 'rest_get'],
        'permission_callback' => [$this, 'check_permissions'],
      ],
      [
        'methods' => 'POST',
        'callback' => [$this, 'rest_save'],
        'permission_callback' => [$this, 'check_permissions'],
        'args' => [
          'settings' => ['required' => true, 'type' => 'object'],
        ],
      ],
    ]);

    register_rest_route('sustainable-theme/v1', '/style-wizard/reset', [
      [
        'methods' => 'POST',
        'callback' => [$this, 'rest_reset'],
        'permission_callback' => [$this, 'check_permissions'],
      ],
    ]);
  }

  public function rest_get(): \WP_REST_Response
  {
    return new \WP_REST_Response([
      'success' => true,
      'settings' => $this->get_settings(),
      'palettes' => self::get_palettes(),
      'identities' => self::get_identity_presets(),
    ]);
  }

  public function rest_save(\WP_REST_Request $request): \WP_REST_Response
  {
    $incoming = $request->get_param('settings');
    if (!is_array($incoming)) {
      return new \WP_REST_Response([
        'success' => false,
        'message' => __('Invalid payload.', 'sustainable-theme'),
      ], 400);
    }

    $sanitized = $this->sanitize_settings($incoming);
    update_option(self::OPTION, $sanitized);

    return new \WP_REST_Response([
      'success' => true,
      'message' => __('Style wizard settings saved.', 'sustainable-theme'),
      'settings' => $sanitized,
    ]);
  }

  public function rest_reset(): \WP_REST_Response
  {
    delete_option(self::OPTION);
    return new \WP_REST_Response([
      'success' => true,
      'message' => __('Style wizard reset to defaults.', 'sustainable-theme'),
      'settings' => self::get_defaults(),
    ]);
  }

  public function check_permissions(): bool
  {
    return current_user_can('manage_options');
  }

  // ─── Scroll Animation Script ──────────────────────────────────

  public function print_animation_script(): void
  {
    $settings = $this->get_settings();
    if (empty($settings['wizard_completed'])) {
      return;
    }
    if ($settings['animation_style'] === 'none') {
      return;
    }
    if (!in_array($settings['animation_trigger'], ['scroll', 'combined'], true)) {
      return;
    }

    ?>
    <script id="sw-scroll-reveal">
    (function(){
      if(window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
      var sel = [
        '.wp-block-group.alignfull > .wp-block-group__inner-container > .wp-block-group',
        '.wp-block-group.alignfull > .wp-block-group__inner-container > .wp-block-columns',
        '.wp-block-group.alignfull > .wp-block-group__inner-container > .wp-block-heading',
        '.wp-block-group.alignfull > .wp-block-group__inner-container > .wp-block-image',
        '.sustainable-theme-cards .wp-block-group.has-background',
        '.wp-block-post-template .wp-block-group',
        '.wp-block-cover:not(:first-child)'
      ].join(',');
      var targets = document.querySelectorAll(sel);
      if(!targets.length) return;
      targets.forEach(function(el){el.classList.add('sw-animate');});
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
          if(e.isIntersecting){
            e.target.classList.add('sw-visible');
            io.unobserve(e.target);
          }
        });
      },{threshold:0.1,rootMargin:'0px 0px -60px 0px'});
      targets.forEach(function(el){io.observe(el);});
    })();
    </script>
    <?php
  }

  // ─── CSS Output ──────────────────────────────────────────────

  public function enqueue_css_variables(): void
  {
    $settings = $this->get_settings();
    if (empty($settings['wizard_completed'])) {
      return;
    }

    $css = $this->build_css($settings);

    if (wp_style_is('sustainable-theme-frontend-styles', 'enqueued')) {
      wp_add_inline_style('sustainable-theme-frontend-styles', $css);
      return;
    }

    wp_register_style('sustainable-theme-style-wizard-vars', false, [], SUSTAINABLE_THEME_VERSION);
    wp_enqueue_style('sustainable-theme-style-wizard-vars');
    wp_add_inline_style('sustainable-theme-style-wizard-vars', $css);
  }


  private function build_css(array $s): string
  {
    $radius_map = [
      'none' => '0',
      'subtle' => '4px',
      'soft' => '12px',
      'rounded' => '20px',
      'pill' => '9999px',
    ];

    $shadow_map = [
      'none' => 'none',
      'subtle' => '0 1px 3px rgba(0,0,0,.08)',
      'medium' => '0 4px 12px rgba(0,0,0,.1)',
      'dramatic' => '0 8px 30px rgba(0,0,0,.15)',
    ];

    $scale_map = [
      'minor-third' => '1.2',
      'major-third' => '1.25',
      'perfect-fourth' => '1.333',
      'augmented-fourth' => '1.414',
    ];

    $spacing_map = [
      'dense' => '0.5',
      'compact' => '0.75',
      'comfortable' => '1',
      'spacious' => '1.5',
      'editorial' => '2',
    ];

    $speed_map = [
      'slow' => '600ms',
      'normal' => '350ms',
      'fast' => '200ms',
    ];

    $weight_map = [
      'light' => '300',
      'normal' => '400',
      'bold' => '700',
      'black' => '900',
    ];

    $letter_spacing_map = [
      'tight' => '-0.03em',
      'normal' => '0',
      'wide' => '0.05em',
      'extra-wide' => '0.12em',
    ];

    $line_height_map = [
      'tight' => '1.2',
      'normal' => '1.5',
      'relaxed' => '1.7',
      'loose' => '2',
    ];

    $content_width_map = [
      'narrow' => '720px',
      'default' => '900px',
      'wide' => '1200px',
      'full-bleed' => '100%',
    ];

    $font_map = [
      'system-ui' => 'system-ui, -apple-system, sans-serif',
      'inter' => "'Inter', system-ui, sans-serif",
      'source-serif' => "'Source Serif 4', Georgia, serif",
      'dm-sans' => "'DM Sans', system-ui, sans-serif",
      'playfair' => "'Playfair Display', Georgia, serif",
      'space-grotesk' => "'Space Grotesk', system-ui, sans-serif",
    ];

    $radius = $radius_map[$s['border_radius']] ?? '12px';
    $card_radius = $s['border_radius'] === 'pill' ? '20px' : $radius;
    $btn_radius = $radius;
    $shadow = $shadow_map[$s['shadow_style']] ?? 'none';
    $scale = $scale_map[$s['type_scale']] ?? '1.2';
    $spacing_mult = $spacing_map[$s['spacing_scale']] ?? '1';
    $anim_speed = $speed_map[$s['animation_speed']] ?? '350ms';
    $heading_weight = $weight_map[$s['heading_weight']] ?? '700';
    $heading_ls = $letter_spacing_map[$s['heading_letter_spacing']] ?? '0';
    $heading_transform = ($s['heading_transform'] ?? 'none') === 'none' ? 'none' : $s['heading_transform'];
    $body_lh = $line_height_map[$s['body_line_height']] ?? '1.5';
    $content_width = $content_width_map[$s['content_width']] ?? '900px';
    $heading_stack = $font_map[$s['font_heading']] ?? 'system-ui, -apple-system, sans-serif';
    $body_stack = $font_map[$s['font_body']] ?? 'system-ui, -apple-system, sans-serif';

    // ── Root custom properties ─────────────────────────────────
    $css = sprintf(
      ':root{' .
      '--sw-color-primary:%s;' .
      '--sw-color-secondary:%s;' .
      '--sw-color-accent:%s;' .
      '--sw-color-background:%s;' .
      '--sw-color-surface:%s;' .
      '--sw-color-text:%s;' .
      '--sw-color-text-muted:%s;' .
      '--sw-font-heading:%s;' .
      '--sw-font-body:%s;' .
      '--sw-type-scale:%s;' .
      '--sw-spacing-multiplier:%s;' .
      '--sw-section-gap:%s;' .
      '--sw-radius:%s;' .
      '--sw-shadow:%s;' .
      '--sw-anim-speed:%s;' .
      '--sw-heading-weight:%s;' .
      '--sw-heading-ls:%s;' .
      '--sw-heading-transform:%s;' .
      '--sw-body-lh:%s;' .
      '--sw-content-width:%s;' .
      '--rounded-card:%s;' .
      '--rounded-image:%s;' .
      '--rounded-button:%s;' .
      '}',
      esc_attr($s['color_primary']),
      esc_attr($s['color_secondary']),
      esc_attr($s['color_accent']),
      esc_attr($s['color_background']),
      esc_attr($s['color_surface']),
      esc_attr($s['color_text']),
      esc_attr($s['color_text_muted']),
      esc_attr($heading_stack),
      esc_attr($body_stack),
      esc_attr($scale),
      esc_attr($spacing_mult),
      esc_attr($s['section_gap']),
      esc_attr($radius),
      esc_attr($shadow),
      esc_attr($anim_speed),
      esc_attr($heading_weight),
      esc_attr($heading_ls),
      esc_attr($heading_transform),
      esc_attr($body_lh),
      esc_attr($content_width),
      esc_attr($card_radius),
      esc_attr($card_radius),
      esc_attr($btn_radius)
    );

    // ── Typography: headings ───────────────────────────────────
    $css .= sprintf(
      'h1,h2,h3,h4,h5,h6,.wp-block-post-title,.wp-block-site-title{' .
      'font-family:%s;' .
      'font-weight:%s;' .
      'letter-spacing:%s;' .
      'text-transform:%s;' .
      '}',
      esc_attr($heading_stack),
      esc_attr($heading_weight),
      esc_attr($heading_ls),
      esc_attr($heading_transform)
    );

    // ── Typography: body line-height ───────────────────────────
    $css .= sprintf(
      'body,.wp-block-paragraph,.wp-block-list{line-height:%s;}',
      esc_attr($body_lh)
    );

    // ── Content width constraint ───────────────────────────────
    if ($s['content_width'] !== 'full-bleed') {
      $css .= sprintf(
        '.wp-site-blocks .wp-block-group:not(.alignfull):not(.alignwide) > .wp-block-group__inner-container,' .
        '.entry-content > *:not(.alignfull):not(.alignwide){' .
        'max-width:%s;margin-left:auto;margin-right:auto;' .
        '}',
        esc_attr($content_width)
      );
    }

    // ── Visual rhythm: section gaps ────────────────────────────
    $section_gap = $s['section_gap'];
    $css .= sprintf(
      '.wp-block-group.alignfull + .wp-block-group.alignfull,' .
      '.wp-block-cover + .wp-block-group.alignfull,' .
      '.wp-block-group.alignfull + .wp-block-cover,' .
      '.wp-block-cover + .wp-block-cover{' .
      'margin-top:%s;' .
      '}',
      esc_attr($section_gap)
    );

    // Vertical rhythm between elements within sections
    $vr_map = ['tight' => '0.5em', 'balanced' => '1em', 'dramatic' => '2em'];
    $vr = $vr_map[$s['vertical_rhythm']] ?? '1em';
    $css .= sprintf(
      '.wp-block-group__inner-container > * + *,' .
      '.wp-block-cover__inner-container > * + *{' .
      'margin-top:%s;' .
      '}' .
      '.wp-block-group__inner-container > * + h1,' .
      '.wp-block-group__inner-container > * + h2,' .
      '.wp-block-group__inner-container > * + h3{' .
      'margin-top:calc(%s * 1.5);' .
      '}',
      esc_attr($vr),
      esc_attr($vr)
    );

    // Spacing density affects padding within sections
    $section_padding_map = [
      'dense' => 'clamp(1rem, 2vw, 2rem)',
      'compact' => 'clamp(1.5rem, 3vw, 3rem)',
      'comfortable' => 'clamp(2rem, 5vw, 5rem)',
      'spacious' => 'clamp(3rem, 7vw, 8rem)',
      'editorial' => 'clamp(4rem, 9vw, 10rem)',
    ];
    $section_pad = $section_padding_map[$s['spacing_scale']] ?? 'clamp(2rem, 5vw, 5rem)';
    $css .= sprintf(
      '.wp-block-group.alignfull{padding-top:%1$s;padding-bottom:%1$s;}' .
      '.wp-block-cover{padding-top:%1$s;padding-bottom:%1$s;}',
      $section_pad
    );

    // ── Card/surface radius override ─────────────────────────────
    // Explicitly set radius on card-like elements (not just via variable)
    $css .= sprintf(
      '.sustainable-theme-cards > .wp-block-group__inner-container > .wp-block-group > .wp-block-group,' .
      '.sustainable-theme-cards .wp-block-group.has-background,' .
      '.wp-block-post-template .wp-block-group,' .
      '.sustainable-rounded-card,' .
      '.wp-block-cover:not(.alignfull){' .
      'border-radius:%s;overflow:hidden;' .
      '}',
      esc_attr($card_radius)
    );

    // Buttons
    $css .= sprintf(
      '.wp-block-button__link{border-radius:%s;}',
      esc_attr($btn_radius)
    );

    // Images
    $css .= sprintf(
      '.wp-block-image img,' .
      '.wp-block-post-featured-image img{' .
      'border-radius:%s;' .
      '}',
      esc_attr($card_radius)
    );

    // ── Card/surface shadows ───────────────────────────────────
    if ($s['shadow_style'] !== 'none') {
      $css .= sprintf(
        '.sustainable-theme-cards .wp-block-group.has-background,' .
        '.sustainable-theme-cards > .wp-block-group__inner-container > .wp-block-group > .wp-block-group,' .
        '.wp-block-post-template .wp-block-group,' .
        '.sustainable-rounded-card{' .
        'box-shadow:%s;' .
        '}',
        esc_attr($shadow)
      );
    }

    // ── Border style ───────────────────────────────────────────
    $border_style = $s['border_style'] ?? 'none';
    if ($border_style === 'subtle') {
      $css .= sprintf(
        '.sustainable-theme-cards .wp-block-group.has-background,' .
        '.wp-block-post-template .wp-block-group,' .
        '.sustainable-rounded-card{' .
        'border:1px solid color-mix(in srgb, %s 20%%, transparent);' .
        '}',
        esc_attr($s['color_text'])
      );
    } elseif ($border_style === 'strong') {
      $css .= sprintf(
        '.sustainable-theme-cards .wp-block-group.has-background,' .
        '.wp-block-post-template .wp-block-group,' .
        '.sustainable-rounded-card,' .
        '.wp-block-image img,' .
        '.wp-block-post-featured-image img{' .
        'border:2px solid %s;' .
        '}',
        esc_attr($s['color_text'])
      );
    } elseif ($border_style === 'brutalist') {
      $css .= sprintf(
        '.sustainable-theme-cards .wp-block-group.has-background,' .
        '.wp-block-post-template .wp-block-group,' .
        '.sustainable-rounded-card,' .
        '.wp-block-image img,' .
        '.wp-block-post-featured-image img,' .
        '.wp-block-cover:not(.alignfull){' .
        'border:3px solid %1$s;' .
        '}' .
        '.wp-block-group.alignfull{' .
        'border-top:2px solid %1$s;' .
        'border-bottom:2px solid %1$s;' .
        '}' .
        '.wp-block-button__link{' .
        'border:2px solid currentColor !important;' .
        'background:transparent !important;' .
        'color:%1$s !important;' .
        '}' .
        '.wp-block-button__link:hover{' .
        'background:%1$s !important;' .
        'color:%2$s !important;' .
        '}',
        esc_attr($s['color_text']),
        esc_attr($s['color_background'])
      );
    }

    // ── Full-bleed specific: remove side padding ───────────────
    if ($s['content_width'] === 'full-bleed') {
      $css .= 'body{--wp--style--root--padding-left:0;--wp--style--root--padding-right:0;}';
    }

    // ── Animations (if not "none") with reduced-motion ─────────
    if ($s['animation_style'] !== 'none') {
      $css .= $this->build_animation_css($s['animation_style'], $s['animation_trigger'], $anim_speed);
    }

    return $css;
  }

  private function build_animation_css(string $style, string $trigger, string $speed): string
  {
    $transform_map = [
      'subtle' => 'translateY(20px)',
      'playful' => 'scale(0.95) translateY(30px)',
      'dramatic' => 'translateY(40px)',
    ];

    $transform = $transform_map[$style] ?? 'translateY(20px)';
    $easing = $style === 'playful' ? 'cubic-bezier(0.34, 1.56, 0.64, 1)' : 'ease-out';

    $css = '';

    // Define the animation keyframes
    $css .= sprintf(
      '@keyframes sw-reveal{from{opacity:0;transform:%s}to{opacity:1;transform:none}}',
      $transform
    );

    // Selector depends on trigger
    if ($trigger === 'scroll' || $trigger === 'combined') {
      // Use .sw-animate class which can be added via IntersectionObserver
      $css .= sprintf(
        '.sw-animate{opacity:0;transform:%s;transition:opacity %s %s,transform %s %s;}' .
        '.sw-animate.sw-visible{opacity:1;transform:none;}',
        $transform,
        $speed, $easing,
        $speed, $easing
      );
    }

    if ($trigger === 'load' || $trigger === 'combined') {
      // Staggered entrance on page load
      $css .= sprintf(
        '.wp-block-cover .wp-block-cover__inner-container > *,' .
        '.entry-content > .wp-block-group:first-child > .wp-block-group__inner-container > *{' .
        'animation:sw-reveal %s %s both;' .
        '}',
        $speed, $easing
      );
      for ($i = 1; $i <= 5; $i++) {
        $delay = $i * 100;
        $css .= sprintf(
          '.wp-block-cover .wp-block-cover__inner-container > :nth-child(%d),' .
          '.entry-content > .wp-block-group:first-child > .wp-block-group__inner-container > :nth-child(%d){' .
          'animation-delay:%dms;}',
          $i, $i, $delay
        );
      }
    }

    if ($trigger === 'hover' || $trigger === 'combined') {
      $css .= sprintf(
        '.sustainable-theme-cards .wp-block-group.has-background,' .
        '.wp-block-post-template .wp-block-group,' .
        '.sustainable-rounded-card{' .
        'transition:transform %s %s,box-shadow %s %s;' .
        '}' .
        '.sustainable-theme-cards .wp-block-group.has-background:hover,' .
        '.wp-block-post-template .wp-block-group:hover,' .
        '.sustainable-rounded-card:hover{' .
        'transform:translateY(-4px);' .
        'box-shadow:0 8px 24px rgba(0,0,0,.12);' .
        '}',
        $speed, $easing, $speed, $easing
      );
    }

    // Respect prefers-reduced-motion
    $css .= '@media(prefers-reduced-motion:reduce){' .
      '.sw-animate,.sw-animate.sw-visible{opacity:1;transform:none;transition:none;}' .
      '.wp-block-cover .wp-block-cover__inner-container > *,' .
      '.entry-content > .wp-block-group:first-child > .wp-block-group__inner-container > *{animation:none;}' .
      '*{transition:none !important;animation:none !important;}' .
      '}';

    return $css;
  }

  // ─── Theme.json integration ──────────────────────────────────

  public function filter_theme_json(\WP_Theme_JSON_Data $theme_json): \WP_Theme_JSON_Data
  {
    $settings = $this->get_settings();
    if (empty($settings['wizard_completed'])) {
      return $theme_json;
    }

    $data = $theme_json->get_data();

    // Inject color palette (replaces the theme default)
    $data['settings']['color']['palette']['theme'] = [
      ['slug' => 'primary', 'color' => $settings['color_primary'], 'name' => 'Primary'],
      ['slug' => 'secondary', 'color' => $settings['color_secondary'], 'name' => 'Secondary'],
      ['slug' => 'accent', 'color' => $settings['color_accent'], 'name' => 'Accent'],
      ['slug' => 'background', 'color' => $settings['color_background'], 'name' => 'Background'],
      ['slug' => 'foreground', 'color' => $settings['color_text'], 'name' => 'Foreground'],
      ['slug' => 'surface', 'color' => $settings['color_surface'], 'name' => 'Surface'],
      ['slug' => 'neutral-1', 'color' => $settings['color_surface'], 'name' => 'Neutral 1'],
      ['slug' => 'neutral-2', 'color' => $settings['color_text_muted'], 'name' => 'Neutral 2'],
      ['slug' => 'tertiary', 'color' => $settings['color_accent'], 'name' => 'Tertiary'],
    ];

    // Apply background/text colors globally
    $data['styles']['color']['background'] = $settings['color_background'];
    $data['styles']['color']['text'] = $settings['color_text'];

    // Inject border radius into custom tokens (overrides DesignSettings if wizard is active)
    $radius_map = [
      'none' => '0',
      'subtle' => '4px',
      'soft' => '12px',
      'rounded' => '20px',
      'pill' => '9999px',
    ];
    $radius = $radius_map[$settings['border_radius']] ?? '12px';
    $btn_radius = $settings['border_radius'] === 'pill' ? '9999px' : $radius;
    $card_radius = $settings['border_radius'] === 'pill' ? '20px' : $radius;

    $data['settings']['custom']['rounded'] = [
      'card' => $card_radius,
      'image' => $card_radius,
      'button' => $btn_radius,
    ];

    // Apply button radius
    if (!isset($data['styles']['elements']['button']['border'])) {
      $data['styles']['elements']['button']['border'] = [];
    }
    $data['styles']['elements']['button']['border']['radius'] = $btn_radius;

    // Apply font family if not system-ui
    $font_map = [
      'system-ui' => 'system-ui, -apple-system, sans-serif',
      'inter' => "'Inter', system-ui, sans-serif",
      'source-serif' => "'Source Serif 4', Georgia, serif",
      'dm-sans' => "'DM Sans', system-ui, sans-serif",
      'playfair' => "'Playfair Display', Georgia, serif",
      'space-grotesk' => "'Space Grotesk', system-ui, sans-serif",
    ];

    $heading_stack = $font_map[$settings['font_heading']] ?? 'system-ui, -apple-system, sans-serif';
    $body_stack = $font_map[$settings['font_body']] ?? 'system-ui, -apple-system, sans-serif';

    $data['styles']['typography']['fontFamily'] = $body_stack;

    // Apply heading styles via block-level settings
    $weight_map = [
      'light' => '300',
      'normal' => '400',
      'bold' => '700',
      'black' => '900',
    ];
    $heading_weight = $weight_map[$settings['heading_weight']] ?? '700';
    $heading_transform = ($settings['heading_transform'] ?? 'none') === 'none' ? '' : $settings['heading_transform'];
    $letter_spacing_map = [
      'tight' => '-0.03em',
      'normal' => '0',
      'wide' => '0.05em',
      'extra-wide' => '0.12em',
    ];
    $heading_ls = $letter_spacing_map[$settings['heading_letter_spacing']] ?? '0';

    $heading_blocks = ['core/heading', 'core/post-title', 'core/site-title'];
    foreach ($heading_blocks as $block) {
      if (!isset($data['styles']['blocks'][$block])) {
        $data['styles']['blocks'][$block] = [];
      }
      if (!isset($data['styles']['blocks'][$block]['typography'])) {
        $data['styles']['blocks'][$block]['typography'] = [];
      }
      $data['styles']['blocks'][$block]['typography']['fontFamily'] = $heading_stack;
      $data['styles']['blocks'][$block]['typography']['fontWeight'] = $heading_weight;
      $data['styles']['blocks'][$block]['typography']['letterSpacing'] = $heading_ls;
      if ($heading_transform) {
        $data['styles']['blocks'][$block]['typography']['textTransform'] = $heading_transform;
      }
    }

    // Content width override
    $content_width_map = [
      'narrow' => '720px',
      'default' => '900px',
      'wide' => '1200px',
      'full-bleed' => '100%',
    ];
    $content_width = $content_width_map[$settings['content_width']] ?? '900px';
    if ($settings['content_width'] !== 'full-bleed') {
      $data['settings']['layout']['contentSize'] = $content_width;
    }
    if ($settings['content_width'] === 'wide' || $settings['content_width'] === 'full-bleed') {
      $data['settings']['layout']['wideSize'] = '1400px';
    }

    // Body line height
    $line_height_map = [
      'tight' => '1.2',
      'normal' => '1.5',
      'relaxed' => '1.7',
      'loose' => '2',
    ];
    $data['styles']['typography']['lineHeight'] = $line_height_map[$settings['body_line_height']] ?? '1.5';

    return new \WP_Theme_JSON_Data($data, 'theme');
  }

  // ─── Visual Identity presets ────────────────────────────────

  public static function get_identity_presets(): array
  {
    return [
      [
        'id' => 'minimal',
        'name' => 'Minimalist',
        'description' => 'Clean lines, generous whitespace, understated elegance',
        'settings' => [
          'palette_id' => 'minimal',
          'color_primary' => '#111827',
          'color_secondary' => '#374151',
          'color_accent' => '#6366f1',
          'color_background' => '#ffffff',
          'color_surface' => '#f9fafb',
          'color_text' => '#111827',
          'color_text_muted' => '#9ca3af',
          'font_heading' => 'inter',
          'font_body' => 'inter',
          'type_scale' => 'minor-third',
          'heading_weight' => 'light',
          'heading_transform' => 'none',
          'heading_letter_spacing' => 'wide',
          'body_line_height' => 'relaxed',
          'spacing_scale' => 'spacious',
          'section_gap' => '120px',
          'content_width' => 'narrow',
          'vertical_rhythm' => 'dramatic',
          'hero_style' => 'minimal-text',
          'content_layout' => 'text-first',
          'border_radius' => 'subtle',
          'shadow_style' => 'none',
          'border_style' => 'subtle',
          'animation_style' => 'subtle',
          'animation_trigger' => 'scroll',
          'animation_speed' => 'slow',
        ],
      ],
      [
        'id' => 'modern',
        'name' => 'Modern & Interactive',
        'description' => 'Dynamic layouts, bold colors, engaging animations',
        'settings' => [
          'palette_id' => 'ocean',
          'color_primary' => '#1d4e89',
          'color_secondary' => '#2a7ab5',
          'color_accent' => '#7ec8e3',
          'color_background' => '#ffffff',
          'color_surface' => '#f0f7fa',
          'color_text' => '#1a1a2e',
          'color_text_muted' => '#64748b',
          'font_heading' => 'space-grotesk',
          'font_body' => 'inter',
          'type_scale' => 'major-third',
          'heading_weight' => 'bold',
          'heading_transform' => 'none',
          'heading_letter_spacing' => 'tight',
          'body_line_height' => 'normal',
          'spacing_scale' => 'comfortable',
          'section_gap' => '80px',
          'content_width' => 'wide',
          'vertical_rhythm' => 'balanced',
          'hero_style' => 'full-cover',
          'content_layout' => 'mixed',
          'border_radius' => 'rounded',
          'shadow_style' => 'medium',
          'border_style' => 'none',
          'animation_style' => 'playful',
          'animation_trigger' => 'combined',
          'animation_speed' => 'normal',
        ],
      ],
      [
        'id' => 'editorial',
        'name' => 'Editorial / Magazine',
        'description' => 'Sophisticated typography, editorial layouts, refined spacing',
        'settings' => [
          'palette_id' => 'botanical',
          'color_primary' => '#1a1a1a',
          'color_secondary' => '#3d3d3d',
          'color_accent' => '#c9a96e',
          'color_background' => '#fefefe',
          'color_surface' => '#f8f6f3',
          'color_text' => '#1a1a1a',
          'color_text_muted' => '#6b6b6b',
          'font_heading' => 'playfair',
          'font_body' => 'source-serif',
          'type_scale' => 'perfect-fourth',
          'heading_weight' => 'normal',
          'heading_transform' => 'none',
          'heading_letter_spacing' => 'tight',
          'body_line_height' => 'relaxed',
          'spacing_scale' => 'editorial',
          'section_gap' => '100px',
          'content_width' => 'narrow',
          'vertical_rhythm' => 'dramatic',
          'hero_style' => 'split-image',
          'content_layout' => 'image-beside',
          'border_radius' => 'none',
          'shadow_style' => 'none',
          'border_style' => 'subtle',
          'animation_style' => 'subtle',
          'animation_trigger' => 'scroll',
          'animation_speed' => 'slow',
        ],
      ],
      [
        'id' => 'brutalist',
        'name' => 'Brutalist / Raw',
        'description' => 'Heavy type, harsh contrasts, no decoration, raw power',
        'settings' => [
          'palette_id' => 'custom',
          'color_primary' => '#000000',
          'color_secondary' => '#1a1a1a',
          'color_accent' => '#ff3300',
          'color_background' => '#ffffff',
          'color_surface' => '#f0f0f0',
          'color_text' => '#000000',
          'color_text_muted' => '#555555',
          'font_heading' => 'space-grotesk',
          'font_body' => 'system-ui',
          'type_scale' => 'augmented-fourth',
          'heading_weight' => 'black',
          'heading_transform' => 'uppercase',
          'heading_letter_spacing' => 'tight',
          'body_line_height' => 'tight',
          'spacing_scale' => 'dense',
          'section_gap' => '40px',
          'content_width' => 'full-bleed',
          'vertical_rhythm' => 'tight',
          'hero_style' => 'oversized-type',
          'content_layout' => 'stacked-full',
          'border_radius' => 'none',
          'shadow_style' => 'none',
          'border_style' => 'brutalist',
          'animation_style' => 'none',
          'animation_trigger' => 'scroll',
          'animation_speed' => 'fast',
        ],
      ],
      [
        'id' => 'organic',
        'name' => 'Organic / Natural',
        'description' => 'Warm tones, flowing curves, gentle motion, nature-inspired',
        'settings' => [
          'palette_id' => 'earth',
          'color_primary' => '#2d6a4f',
          'color_secondary' => '#40916c',
          'color_accent' => '#95d5b2',
          'color_background' => '#fefdfb',
          'color_surface' => '#f5f0eb',
          'color_text' => '#2c3e2d',
          'color_text_muted' => '#7c8c7d',
          'font_heading' => 'dm-sans',
          'font_body' => 'dm-sans',
          'type_scale' => 'major-third',
          'heading_weight' => 'bold',
          'heading_transform' => 'none',
          'heading_letter_spacing' => 'normal',
          'body_line_height' => 'relaxed',
          'spacing_scale' => 'spacious',
          'section_gap' => '100px',
          'content_width' => 'default',
          'vertical_rhythm' => 'balanced',
          'hero_style' => 'boxed',
          'content_layout' => 'image-beside',
          'border_radius' => 'rounded',
          'shadow_style' => 'subtle',
          'border_style' => 'none',
          'animation_style' => 'subtle',
          'animation_trigger' => 'scroll',
          'animation_speed' => 'slow',
        ],
      ],
    ];
  }

  // ─── Palette presets ─────────────────────────────────────────

  public static function get_palettes(): array
  {
    return [
      [
        'id' => 'earth',
        'name' => 'Earth & Forest',
        'description' => 'Rich greens and warm browns inspired by nature',
        'colors' => [
          'primary' => '#2d6a4f',
          'secondary' => '#40916c',
          'accent' => '#95d5b2',
          'background' => '#ffffff',
          'surface' => '#f8faf9',
          'text' => '#1b1b1b',
          'text_muted' => '#6b7280',
        ],
      ],
      [
        'id' => 'ocean',
        'name' => 'Ocean Breeze',
        'description' => 'Cool blues and teals reminiscent of coastal waters',
        'colors' => [
          'primary' => '#1d4e89',
          'secondary' => '#2a7ab5',
          'accent' => '#7ec8e3',
          'background' => '#ffffff',
          'surface' => '#f0f7fa',
          'text' => '#1a1a2e',
          'text_muted' => '#64748b',
        ],
      ],
      [
        'id' => 'sunset',
        'name' => 'Warm Sunset',
        'description' => 'Warm terracotta, amber and soft pinks',
        'colors' => [
          'primary' => '#c2452d',
          'secondary' => '#e07a5f',
          'accent' => '#f4a261',
          'background' => '#ffffff',
          'surface' => '#fdf6f0',
          'text' => '#2d2d2d',
          'text_muted' => '#78716c',
        ],
      ],
      [
        'id' => 'minimal',
        'name' => 'Minimalist Mono',
        'description' => 'Clean blacks, whites and grays for a modern look',
        'colors' => [
          'primary' => '#111827',
          'secondary' => '#374151',
          'accent' => '#6366f1',
          'background' => '#ffffff',
          'surface' => '#f9fafb',
          'text' => '#111827',
          'text_muted' => '#9ca3af',
        ],
      ],
      [
        'id' => 'botanical',
        'name' => 'Botanical Garden',
        'description' => 'Sage greens with dusty rose and cream',
        'colors' => [
          'primary' => '#5f7161',
          'secondary' => '#6d8b74',
          'accent' => '#d0b8a8',
          'background' => '#fefefe',
          'surface' => '#f5f0eb',
          'text' => '#2c3e2d',
          'text_muted' => '#7c8c7d',
        ],
      ],
      [
        'id' => 'nordic',
        'name' => 'Nordic Frost',
        'description' => 'Icy blues with warm wood tones and crisp whites',
        'colors' => [
          'primary' => '#2e4057',
          'secondary' => '#4a7c94',
          'accent' => '#b8d4e3',
          'background' => '#ffffff',
          'surface' => '#f4f7f9',
          'text' => '#1e293b',
          'text_muted' => '#64748b',
        ],
      ],
    ];
  }
}
