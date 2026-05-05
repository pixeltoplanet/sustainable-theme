/**
 * Inspects core Video block to disable the autoplay toggle for sustainability.
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const withVideoAutoplayDisabled = createHigherOrderComponent(
	( BlockEdit ) => ( props ) => {
		if ( props.name !== 'core/video' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes, isSelected } = props;

		// Force autoplay to false if it somehow gets enabled
		useEffect( () => {
			if ( attributes.autoplay ) {
				setAttributes( { autoplay: false } );
			}
		}, [ attributes.autoplay, setAttributes ] );

		// A fast, lightweight check to hide the Autoplay toggle in the sidebar.
		// Uses WP core translation for 'Autoplay' so it works robustly in any language,
		// addressing the reviewer feedback without breaking the block's internal state.
		useEffect( () => {
			if ( ! isSelected ) {
				return;
			}

			// We use a short timeout because InspectorControls are rendered
			// via a portal and may not be immediately in the DOM.
			const timeoutId = setTimeout( () => {
				const labels = document.querySelectorAll(
					'.components-toggle-control__label'
				);
				const targetLabelText = __( 'Autoplay', 'default' );

				for ( const label of labels ) {
					if ( label.textContent === targetLabelText ) {
						const wrapper = label.closest( '.components-base-control' );
						if ( wrapper && wrapper.style.display !== 'none' ) {
							wrapper.style.display = 'none';
						}
					}
				}
			}, 50 );

			return () => clearTimeout( timeoutId );
		}, [ isSelected ] );

		// Clone props to force autoplay to false for the initial render.
		// useEffect runs AFTER the first render. If we don't force it here,
		// the <video autoplay> tag mounts, the browser starts playing it, and 
		// removing the attribute via useEffect later won't stop the playback.
		const customProps = { ...props };
		if ( customProps.attributes.autoplay ) {
			customProps.attributes = {
				...customProps.attributes,
				autoplay: false
			};
		}

		return <BlockEdit { ...customProps } />;
	},
	'withVideoAutoplayDisabled'
);

addFilter(
	'editor.BlockEdit',
	'sustainable-theme/video-disable-autoplay',
	withVideoAutoplayDisabled
);
