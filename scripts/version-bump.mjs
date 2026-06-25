#!/usr/bin/env node

/**
 * Bumps the theme version across all three source files:
 *   - package.json        (version field)
 *   - style.css           (Version: header)
 *   - functions.php       (SUSTAINABLE_THEME_VERSION constant)
 *
 * Usage:
 *   node scripts/version-bump.mjs patch   →  1.0.0 → 1.0.1
 *   node scripts/version-bump.mjs minor   →  1.0.0 → 1.1.0
 *   node scripts/version-bump.mjs major   →  1.0.0 → 2.0.0
 *   node scripts/version-bump.mjs 2.3.0   →  sets exact version
 */

import { readFileSync, writeFileSync } from "node:fs";
import { resolve, dirname } from "node:path";
import { fileURLToPath } from "node:url";

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = resolve(__dirname, "..");

const files = {
	packageJson: resolve(root, "package.json"),
	styleCss: resolve(root, "style.css"),
	functionsPHP: resolve(root, "functions.php"),
};

function getCurrentVersion() {
	const pkg = JSON.parse(readFileSync(files.packageJson, "utf8"));
	return pkg.version;
}

function bump(current, type) {
	const [major, minor, patch] = current.split(".").map(Number);
	switch (type) {
		case "major":
			return `${major + 1}.0.0`;
		case "minor":
			return `${major}.${minor + 1}.0`;
		case "patch":
			return `${major}.${minor}.${patch + 1}`;
		default:
			if (/^\d+\.\d+\.\d+$/.test(type)) return type;
			console.error(`Invalid argument: "${type}". Use patch, minor, major, or an explicit X.Y.Z version.`);
			process.exit(1);
	}
}

function updatePackageJson(version) {
	const content = readFileSync(files.packageJson, "utf8");
	const updated = content.replace(/"version":\s*"[^"]*"/, `"version": "${version}"`);
	writeFileSync(files.packageJson, updated);
}

function updateStyleCss(version) {
	const content = readFileSync(files.styleCss, "utf8");
	const updated = content.replace(/Version:\s*\S+/, `Version: ${version}`);
	writeFileSync(files.styleCss, updated);
}

function updateFunctionsPHP(version) {
	const content = readFileSync(files.functionsPHP, "utf8");
	const updated = content.replace(
		/define\('SUSTAINABLE_THEME_VERSION',\s*'[^']*'\)/,
		`define('SUSTAINABLE_THEME_VERSION', '${version}')`,
	);
	writeFileSync(files.functionsPHP, updated);
}

const arg = process.argv[2];
if (!arg) {
	console.error("Usage: version-bump.mjs <patch|minor|major|X.Y.Z>");
	process.exit(1);
}

const current = getCurrentVersion();
const next = bump(current, arg);

updatePackageJson(next);
updateStyleCss(next);
updateFunctionsPHP(next);

console.log(`${current} → ${next}`);
console.log(`  ✓ package.json`);
console.log(`  ✓ style.css`);
console.log(`  ✓ functions.php`);
