/**
 * Extends core Video block to enforce autoplay=false for sustainability.
 *
 * The heavy lifting is done server-side by unregistering the autoplay
 * attribute from the block schema (see class-video-block.php). This JS
 * acts as a belt-and-suspenders safety net: if a user ever manages to
 * set autoplay=true via the Code Editor, we silently reset it.
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { useEffect } from '@wordpress/element';

const withVideoAutoplayDisabled = createHigherOrderComponent(
	( BlockEdit ) => ( props ) => {
		if ( props.name !== 'core/video' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;

		// Safety net: if autoplay is ever true (e.g. set via Code Editor),
		// reset it. useEffect avoids the render-loop risk of setTimeout.
		useEffect( () => {
			if ( attributes.autoplay ) {
				setAttributes( { autoplay: false } );
			}
		}, [ attributes.autoplay, setAttributes ] );

		return <BlockEdit { ...props } />;
	},
	'withVideoAutoplayDisabled'
);

addFilter(
	'editor.BlockEdit',
	'sustainable-theme/video-disable-autoplay',
	withVideoAutoplayDisabled
);
