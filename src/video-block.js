/**
 * Inspects core Video block to disable the autoplay toggle for sustainability.
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';

const withVideoAutoplayDisabled = createHigherOrderComponent(
	( BlockEdit ) => ( props ) => {
		if ( props.name !== 'core/video' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;

		// Force autoplay to false if it somehow gets enabled
		if ( attributes.autoplay ) {
			setTimeout( () => {
				setAttributes( { autoplay: false } );
			}, 0 );
		}

		// A fast, lightweight check to hide the Autoplay toggle in the sidebar.
		// Since we can't reliably inject CSS to target a specific label text without :has(),
		// we use JS to find the label and hide its parent control container.
		setTimeout( () => {
			const labels = document.querySelectorAll(
				'.components-toggle-control__label'
			);
			for ( const label of labels ) {
				if (
					label.textContent === 'Autoplay' ||
					label.textContent === 'Automatisch afspelen'
				) {
					const wrapper = label.closest( '.components-base-control' );
					if ( wrapper && wrapper.style.display !== 'none' ) {
						wrapper.style.display = 'none';
					}
				}
			}
		}, 50 );

		return (
			<Fragment>
				<BlockEdit { ...props } />
			</Fragment>
		);
	},
	'withVideoAutoplayDisabled'
);

addFilter(
	'editor.BlockEdit',
	'sustainable-theme/video-disable-autoplay',
	withVideoAutoplayDisabled
);
