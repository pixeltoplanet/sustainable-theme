/**
 * API utility functions for the Sustainable Theme
 */

/**
 * Load settings from the WordPress REST API
 * @returns {Promise<Object>} Settings object
 */
export const loadSettings = async () => {
	try {
		const response = await fetch("/wp-json/sustainable-theme/v1/settings", {
			method: "GET",
			headers: {
				"Content-Type": "application/json",
				"X-WP-Nonce": window.wpApiSettings?.nonce || "",
			},
		});

		if (response.ok) {
			const data = await response.json();
			return data;
		} else {
			throw new Error(`Failed to load settings: ${response.status}`);
		}
	} catch (error) {
		console.error("Failed to load settings:", error);
		throw error;
	}
};

/**
 * Save settings via the WordPress REST API
 * @param {Object} settings - Settings object to save
 * @returns {Promise<Object>} Response data
 */
export const saveSettings = async (settings) => {
	try {
		const response = await fetch("/wp-json/sustainable-theme/v1/settings", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
				"X-WP-Nonce": window.wpApiSettings?.nonce || "",
			},
			body: JSON.stringify({ settings }),
		});

		const data = await response.json();

		if (response.ok && data.success) {
			return {
				success: true,
				settings: data.settings,
				message: data.message || "Settings saved successfully!",
			};
		} else {
			return {
				success: false,
				message: data.message || "Failed to save settings.",
			};
		}
	} catch (error) {
		console.error("Failed to save settings:", error);
		return {
			success: false,
			message: "An error occurred while saving settings.",
		};
	}
};

/**
 * Test sustainability settings via the WordPress REST API
 * @returns {Promise<Object>} Test results
 */
export const testSettings = async () => {
	try {
		const response = await fetch("/wp-json/sustainable-theme/v1/test-settings", {
			method: "GET",
			headers: {
				"Content-Type": "application/json",
				"X-WP-Nonce": window.wpApiSettings?.nonce || "",
			},
		});

		if (response.ok) {
			const data = await response.json();
			return {
				success: true,
				summary: data.summary,
				results: data.results,
				formattedReport: data.formatted_report,
			};
		} else {
			const errorData = await response.json();
			return {
				success: false,
				message: errorData.message || "Failed to run tests.",
			};
		}
	} catch (error) {
		console.error("Failed to test settings:", error);
		return {
			success: false,
			message: "An error occurred while testing settings.",
		};
	}
};

/**
 * Clean up database via the WordPress REST API
 * @returns {Promise<Object>} Response data
 */
export const cleanupDatabase = async () => {
	try {
		const response = await fetch("/wp-json/sustainable-theme/v1/database/cleanup", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
				"X-WP-Nonce": window.wpApiSettings?.nonce || "",
			},
		});

		const data = await response.json();

		if (response.ok && data.success) {
			return {
				success: true,
				message: data.message || "Database cleaned up successfully!",
			};
		} else {
			return {
				success: false,
				message: data.message || "Failed to clean up database.",
			};
		}
	} catch (error) {
		console.error("Failed to clean up database:", error);
		return {
			success: false,
			message: "An error occurred while cleaning up the database.",
		};
	}
};
