=== The Sustainable Theme ===
Contributors: pixeltoplanet
Tags: block-patterns, block-styles, custom-colors, custom-menu, editor-style, full-site-editing, template-editing, wide-blocks
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A sustainable WordPress block theme with built-in performance tooling, design tokens, and a rich pattern library.

== Description ==

The Sustainable Theme is a modern full-site editing block theme for creative and content-focused websites. It pairs clean typography and flexible layouts with built-in tools to reduce page weight, server load, and unnecessary WordPress overhead.

**Highlights**

* Full-site editing block theme with `theme.json` and style variations
* Sustainability optimizer with base, super, and custom performance modes
* Design settings admin page for border-radius tokens
* Grid-awareness support for carbon-aware browsing (optional)
* Extensive block pattern library, including homepage and portfolio layouts
* React-powered admin pages for settings, sustainability, and design
* Self-hosted updates via GitHub Releases

**Documentation**

Detailed guides are included in the theme's `docs/` folder and on GitHub:

* Sustainability features
* Developer guide
* REST API reference
* Testing guides

Theme website: https://pixeltoplanet.earth/the-sustainable-theme
Repository: https://github.com/pixeltoplanet/sustainable-theme

== Installation ==

1. Upload the `sustainable-theme` folder to `/wp-content/themes/`
2. Activate the theme through the **Appearance → Themes** menu in WordPress
3. Open **Sustainable Theme** in the admin to configure settings
4. Use the Site Editor to customize templates, patterns, and styles

If installing from source, run `composer install --no-dev` and build frontend assets with `bun install && bun run build` before activation.

== Frequently Asked Questions ==

= Does this theme collect user data? =

No tracking is enabled by default. Optional integrations (such as a grid-awareness API key) are administrator-controlled and opt-in only.

= Where are sustainability settings? =

Go to **Sustainable Theme → Sustainability** in the WordPress admin.

= How do theme updates work? =

The theme checks GitHub Releases for new versions. Updates appear under **Appearance → Themes** when a newer release is available.

= Is this theme accessibility-ready? =

The theme follows block theme conventions including skip links on `<main>`. Additional accessibility-ready requirements apply only if you tag the theme as accessibility-ready in the WordPress.org directory.

== Changelog ==

= 0.1.0 =
* Initial public release
* Sustainability optimizer and admin tooling
* Design settings with border-radius tokens
* Block patterns and style variations
* Self-hosted update checker via GitHub Releases
* Automated release workflow

== Upgrade Notice ==

= 0.1.0 =
Initial release of The Sustainable Theme.

== Resources ==

Bundled placeholder images in `assets/images/` are included with the theme for block pattern demos.

Bundled fonts in `assets/fonts/` are included with the theme. Font files are sourced from open font projects compatible with the GPL.

For full documentation, see the `docs/` directory in the theme or the GitHub repository.
