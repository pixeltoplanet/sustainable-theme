/**
 * Settings utility functions for the Sustainable Theme
 */

/**
 * Get default settings object
 * @returns {Object} Default settings configuration
 */
export const getDefaultSettings = () => ({
	sustainability_mode: "base",
	dequeue_non_sustainable: false,
	use_grid_awareness: false,
	electricity_maps_api_key: "",
	disable_rss_feed: false,
	disable_emojis: false,
	remove_embeds: false,
	remove_header_metadata: false,
	remove_rest_output: false,
	disable_xmlrpc: false,
	disable_self_pingbacks: false,
	remove_jquery_migrate: false,
	// Additional sustainability settings
	remove_shortlinks: false,
	disable_heartbeat: false,
	limit_post_revisions: false,
	remove_query_strings: false,
	disable_comments: false,
	remove_wp_version: false,
	remove_dns_prefetch: false,
	disable_dashicons_frontend: false,
	reduce_heartbeat_frequency: false,
	disable_gravatar: false,
	remove_capital_p_dangit: false,
	disable_automatic_updates: false,
	// Lazy loading settings
	enable_lazy_loading: false,
	above_fold_image_limit: 2,
	// Image optimization settings
	enable_image_optimization: false,
	remove_default_image_sizes: false,
});

/**
 * Get settings configuration for a specific sustainability mode
 * @param {string} mode - The sustainability mode ('base', 'super', 'custom')
 * @param {Object} currentSettings - Current settings to preserve certain values
 * @returns {Object} Settings configuration for the specified mode
 */
export const getModeSettings = (mode, currentSettings = {}) => {
	const baseSettings = {
		sustainability_mode: mode,
		dequeue_non_sustainable: false,
		use_grid_awareness: false,
		electricity_maps_api_key: "",
		disable_rss_feed: false,
		disable_emojis: false,
		remove_embeds: false,
		remove_header_metadata: false,
		remove_rest_output: false,
		disable_xmlrpc: false,
		disable_self_pingbacks: false,
		remove_jquery_migrate: false,
		// Additional sustainability settings
		remove_shortlinks: false,
		disable_heartbeat: false,
		limit_post_revisions: false,
		remove_query_strings: false,
		disable_comments: false,
		remove_wp_version: false,
			remove_dns_prefetch: false,
			disable_dashicons_frontend: false,
			reduce_heartbeat_frequency: false,
			disable_gravatar: false,
			remove_capital_p_dangit: true,
			disable_automatic_updates: false,
		// Lazy loading settings
		enable_lazy_loading: false,
		above_fold_image_limit: 2,
		// Image optimization settings
		enable_image_optimization: false,
		remove_default_image_sizes: false,
	};

	switch (mode) {
		case "base":
			return {
				...baseSettings,
				sustainability_mode: "base",
				use_grid_awareness: currentSettings.use_grid_awareness || false, // Preserve current grid awareness setting
				electricity_maps_api_key: currentSettings.electricity_maps_api_key || "", // Preserve existing API key
				disable_emojis: true,
				remove_embeds: true,
				remove_header_metadata: true,
				disable_self_pingbacks: true,
				remove_jquery_migrate: true,
				// Base mode additions
				remove_shortlinks: true,
				disable_heartbeat: false,
				limit_post_revisions: 3,
				remove_query_strings: true,
				// Base mode lazy loading
				enable_lazy_loading: true,
				above_fold_image_limit: 2,
				// Base mode image optimization
				enable_image_optimization: true,
				remove_default_image_sizes: false,
			};
		case "super":
			return {
				...baseSettings,
				sustainability_mode: "super",
				dequeue_non_sustainable: true,
				use_grid_awareness: currentSettings.use_grid_awareness || false, // Preserve current grid awareness setting
				electricity_maps_api_key: currentSettings.electricity_maps_api_key || "", // Preserve existing API key
				disable_rss_feed: true,
				disable_emojis: true,
				remove_embeds: true,
				remove_header_metadata: true,
				remove_rest_output: true,
				disable_xmlrpc: true,
				disable_self_pingbacks: true,
				remove_jquery_migrate: true,
				// Super mode additions
				remove_shortlinks: true,
				disable_heartbeat: true,
				limit_post_revisions: 1,
				remove_query_strings: true,
				disable_comments: true,
				remove_wp_version: true,
				remove_dns_prefetch: true,
				disable_dashicons_frontend: true,
				reduce_heartbeat_frequency: false, // Can't reduce frequency when disabled
				disable_gravatar: true,
				remove_capital_p_dangit: true,
				disable_automatic_updates: true,
				// Super mode lazy loading
				enable_lazy_loading: true,
				above_fold_image_limit: 1,
				// Super mode image optimization
				enable_image_optimization: true,
				remove_default_image_sizes: true,
			};
		case "custom":
			// Keep current settings when switching to custom mode
			return {
				...currentSettings,
				sustainability_mode: "custom",
			};
		default:
			return baseSettings;
	}
};

/**
 * Check if settings have changed from original
 * @param {Object} settings - Current settings
 * @param {Object} originalSettings - Original settings to compare against
 * @returns {boolean} True if settings have changed
 */
export const hasSettingsChanged = (settings, originalSettings) => {
	if (!originalSettings) {
		// If no original settings, check if current settings differ from defaults
		const defaults = getDefaultSettings();
		return JSON.stringify(settings) !== JSON.stringify(defaults);
	}
	
	// Normalize both objects by sorting keys and handling undefined/null
	const normalize = (obj) => {
		const normalized = {};
		// Get all unique keys from both objects
		const allKeys = new Set([...Object.keys(obj || {}), ...Object.keys(originalSettings || {})]);
		
		allKeys.forEach(key => {
			const value = obj?.[key];
			// Convert undefined to null for consistent comparison
			normalized[key] = value === undefined ? null : value;
		});
		
		// Sort keys for consistent stringification
		return Object.keys(normalized).sort().reduce((acc, key) => {
			acc[key] = normalized[key];
			return acc;
		}, {});
	};
	
	const normalizedCurrent = normalize(settings);
	const normalizedOriginal = normalize(originalSettings);
	
	return JSON.stringify(normalizedCurrent) !== JSON.stringify(normalizedOriginal);
};

/**
 * Get sustainability mode display name
 * @param {string} mode - The sustainability mode
 * @returns {string} Display name for the mode
 */
export const getModeDisplayName = (mode) => {
	switch (mode) {
		case "base":
			return "Sustainable";
		case "super":
			return "Super Sustainable";
		case "custom":
			return "Custom";
		default:
			return "Unknown";
	}
};
