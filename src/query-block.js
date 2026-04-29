/**
 * Inspects core Query (Query Loop) with "Exclude current post" toggle.
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const EXCLUDE_KEY = 'sustainable_exclude_current';

const withSustainableQueryExcludeCurrent = createHigherOrderComponent(
	(BlockEdit) => (props) => {
		if (props.name !== 'core/query') {
			return <BlockEdit {...props} />;
		}

		const { attributes, setAttributes } = props;
		const query = attributes.query || {};
		const excludeCurrent = Boolean(query[EXCLUDE_KEY]);

		return (
			<Fragment>
				<BlockEdit {...props} />
				<InspectorControls>
					<PanelBody
						title={__('Related & context', 'sustainable-theme')}
						initialOpen={false}
					>
						<ToggleControl
							label={__('Exclude current post', 'sustainable-theme')}
							help={__(
								'On singular views, hides the post being viewed from this list when it matches the query post type. In the post editor, preview usually reflects this; the Site Editor may not have a "current" post in the same way.',
								'sustainable-theme',
							)}
							checked={excludeCurrent}
							onChange={(value) => {
								setAttributes({
									query: {
										...query,
										[EXCLUDE_KEY]: value,
									},
								});
							}}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	},
	'withSustainableQueryExcludeCurrent',
);

addFilter(
	'editor.BlockEdit',
	'sustainable-theme/query-exclude-current',
	withSustainableQueryExcludeCurrent,
);
