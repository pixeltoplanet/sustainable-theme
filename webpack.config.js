const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("node:path");

module.exports = {
	...defaultConfig,
	entry: {
		admin: path.resolve(process.cwd(), "src", "admin.js"),
		"design-admin": path.resolve(process.cwd(), "src", "design-admin.js"),
		"sustainability-admin": path.resolve(process.cwd(), "src", "sustainability-admin.js"),
		frontend: path.resolve(process.cwd(), "src", "frontend.js"),
		"frontend-styles": path.resolve(
			process.cwd(),
			"src",
			"styles",
			"styles.scss",
		),
		"grid-aware-styles": path.resolve(
			process.cwd(),
			"src",
			"styles",
			"grid-aware.scss",
		),
	},
	output: {
		path: path.resolve(process.cwd(), "build"),
		filename: "[name].js",
	},
};
