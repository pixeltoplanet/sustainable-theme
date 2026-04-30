/**
 * Inspects core Post Excerpt with "Hide Read More" toggle.
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const HIDE_READ_MORE_KEY = 'sustainableHideReadMore';

const withSustainableExcerptHideReadMore = createHigherOrderComponent(
	( BlockEdit ) => ( props ) => {
		if ( props.name !== 'core/post-excerpt' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;
		const hideReadMore = Boolean( attributes[ HIDE_READ_MORE_KEY ] );

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody
						title={ __(
							'Read More settings',
							'sustainable-theme'
						) }
						initialOpen={ false }
					>
						<ToggleControl
							label={ __(
								'Hide Read More',
								'sustainable-theme'
							) }
							help={ __(
								'When enabled, the "Read More" link is hidden on the front end.',
								'sustainable-theme'
							) }
							checked={ hideReadMore }
							onChange={ ( value ) => {
								setAttributes( {
									[ HIDE_READ_MORE_KEY ]: value,
								} );
							} }
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	},
	'withSustainableExcerptHideReadMore'
);

addFilter(
	'editor.BlockEdit',
	'sustainable-theme/excerpt-hide-read-more',
	withSustainableExcerptHideReadMore
);
