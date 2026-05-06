/**
 * Sustainably neutralises the autoplay feature of the core Video block.
 *
 * Behaviour is gated by the `disable_video_autoplay` theme setting,
 * exposed to this bundle via an inline script as
 * `window.sustainableTheme.disableVideoAutoplay`. When the setting is
 * off, this module registers nothing and core behaviour is preserved.
 *
 * When the setting is on, we use only public, supported APIs:
 *  1. `blocks.registerBlockType` — set the `autoplay` attribute default to
 *     `false` so newly inserted videos never start with autoplay enabled.
 *  2. `editor.BlockEdit` — wrap the block's edit component to:
 *       a. Force `autoplay` back to `false` if it ever becomes truthy
 *          (e.g. imported content), keeping editor + saved markup honest.
 *       b. Intercept `setAttributes` so the inspector's Autoplay toggle
 *          is a true no-op (also blocks the `muted` / `playsInline`
 *          side-effects core's handler bundles into the same patch).
 *       c. Render a Notice in InspectorAdvancedControls explaining why
 *          autoplay is disabled and where to change the setting.
 *
 * The frontend is additionally protected by `class-video-block.php`,
 * which strips any stray `autoplay` attribute via `WP_HTML_Tag_Processor`,
 * also gated by the same setting.
 *
 * Note: we deliberately do NOT visually disable the toggle via DOM
 * manipulation — observing the editor DOM has an ongoing CPU/energy cost
 * which conflicts with the theme's sustainability goals. The Notice plus
 * the `setAttributes` interceptor give the same UX outcome at zero cost.
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { Notice } from '@wordpress/components';
import { Fragment, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const isEnabled =
	typeof window !== 'undefined' &&
	window.sustainableTheme?.disableVideoAutoplay === true;

if ( isEnabled ) {
	addFilter(
		'blocks.registerBlockType',
		'sustainable-theme/video-autoplay-default',
		( settings, name ) => {
			if ( name !== 'core/video' || ! settings.attributes?.autoplay ) {
				return settings;
			}
			return {
				...settings,
				attributes: {
					...settings.attributes,
					autoplay: {
						...settings.attributes.autoplay,
						default: false,
					},
				},
			};
		}
	);

	const withAutoplayDisabled = createHigherOrderComponent(
		( BlockEdit ) => ( props ) => {
			if ( props.name !== 'core/video' ) {
				return <BlockEdit { ...props } />;
			}

			const { attributes, setAttributes, isSelected } = props;

			useEffect( () => {
				if ( attributes.autoplay ) {
					setAttributes( { autoplay: false } );
				}
			}, [ attributes.autoplay, setAttributes ] );

			// Core's autoplay toggle dispatches a single setAttributes
			// call that also flips `muted` and `playsInline`. Drop any
			// patch that touches `autoplay` so clicking the toggle is a
			// true no-op; unrelated edits to muted / playsInline still
			// pass through untouched.
			const interceptedSetAttributes = ( patch ) => {
				if (
					patch &&
					Object.prototype.hasOwnProperty.call( patch, 'autoplay' )
				) {
					return;
				}
				setAttributes( patch );
			};

			const safeProps = {
				...props,
				setAttributes: interceptedSetAttributes,
				attributes: attributes.autoplay
					? { ...attributes, autoplay: false }
					: attributes,
			};

			return (
				<Fragment>
					<BlockEdit { ...safeProps } />
					{ isSelected && (
						<InspectorAdvancedControls>
							<Notice
								status="info"
								isDismissible={ false }
							>
								{ __(
									'Autoplay is disabled by this theme to save bandwidth and improve accessibility. You can change this in Theme Settings → Sustainability.',
									'sustainable-theme'
								) }
							</Notice>
						</InspectorAdvancedControls>
					) }
				</Fragment>
			);
		},
		'withAutoplayDisabled'
	);

	addFilter(
		'editor.BlockEdit',
		'sustainable-theme/video-disable-autoplay',
		withAutoplayDisabled
	);
}
