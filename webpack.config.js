const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'node:path' );

module.exports = {
	...defaultConfig,
	entry: {
		admin: path.resolve( process.cwd(), 'src', 'admin.js' ),
		'query-block': path.resolve( process.cwd(), 'src', 'query-block.js' ),
		'excerpt-block': path.resolve(
			process.cwd(),
			'src',
			'excerpt-block.js'
		),
		frontend: path.resolve( process.cwd(), 'src', 'frontend.js' ),
		'frontend-styles': path.resolve(
			process.cwd(),
			'src',
			'styles',
			'styles.scss'
		),
		'grid-aware-styles': path.resolve(
			process.cwd(),
			'src',
			'styles',
			'grid-aware.scss'
		),
		'editor-styles': path.resolve(
			process.cwd(),
			'src',
			'styles',
			'editor.scss'
		),
	},
	output: {
		path: path.resolve( process.cwd(), 'build' ),
		filename: '[name].js',
	},
};
