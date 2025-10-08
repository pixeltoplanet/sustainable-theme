/**
 * Grid Awareness TypeScript Module
 *
 * Integrates with @greenweb/grid-aware-websites package to provide real-time
 * carbon intensity data and grid awareness functionality for WordPress themes.
 *
 * @package SustainableTheme
 * @since 1.0.0
 *
 * @link https://www.npmjs.com/package/@greenweb/grid-aware-websites
 * @link https://api-portal.electricitymaps.com/
 */

import { GridIntensity } from "@greenweb/grid-aware-websites";

// ============================================================================
// TYPE DEFINITIONS
// ============================================================================

/**
 * Grid settings passed from PHP backend via wp_localize_script
 */
interface GridSettings {
	/** Whether grid awareness is enabled */
	enabled: boolean | string | number;
	/** REST API endpoint URL for grid status */
	apiUrl: string;
	/** WordPress nonce for API requests */
	nonce?: string;
	/** API key for Electricity Maps */
	apiKey?: string;
}

/**
 * GridIntensity configuration options (recreated from package internals)
 */
interface GridIntensityOptions {
	mode?: "level" | "average" | "limit";
	minimumIntensity?: number;
	dataProvider?: string;
	apiKey?: string;
}

/**
 * Response from @greenweb/grid-aware-websites GridIntensity.check() method
 */
interface GridIntensityResponse {
	status: "success" | "error";
	region?: string;
	gridAware?: boolean; // For average/limit modes
	level?: "low" | "moderate" | "high"; // For level mode
	data?: {
		mode: string;
		carbonIntensity?: number; // For average/limit modes
		datetime?: string; // For level mode
		minimumIntensity?: number; // For limit mode
		averageIntensity?: number; // For average mode
	};
	message?: string; // For error responses
	details?: unknown; // For error responses
}

/**
 * Extend Window interface to include our custom property
 */
declare global {
	interface Window {
		sustainableThemeGridSettings?: GridSettings;
	}
}

/**
 * Grid intensity data structure returned by our REST API
 */
interface GridIntensityData {
	/** Whether the grid is cleaner than average */
	is_green: boolean;
	/** Clean energy percentage (0-100) */
	grid_intensity: number;
	/** Grid intensity label following @greenweb package standards */
	grid_intensity_label: "low" | "moderate" | "high";
	/** Country/region code (e.g., 'NL', 'DE') */
	region: string;
	/** Human-readable country name */
	country_name: string;
	/** Carbon intensity in gCO2/kWh */
	carbon_intensity: number;
	/** MySQL timestamp of last update */
	last_updated: string;
}

/**
 * REST API response structure
 */
interface GridApiResponse {
	/** Whether the API request was successful */
	success: boolean;
	/** Grid intensity data */
	data: GridIntensityData;
	/** Whether in development mode */
	development: boolean;
}

/**
 * Geolocation coordinates
 */
interface GeolocationCoords {
	/** Latitude */
	lat: string;
	/** Longitude */
	lon: string;
}

/**
 * Country name mapping for region codes
 */
interface CountryNames {
	[key: string]: string;
}

/**
 * Grid intensity class for CSS styling
 */
type IntensityClass = "very-green" | "green" | "yellow" | "orange" | "red";

/**
 * Grid intensity color mapping
 */
interface IntensityColors {
	[key: string]: string;
}

/**
 * Admin statistics data structure
 */
interface AdminStats {
	/** Whether grid awareness is enabled */
	enabled: boolean;
	/** Whether grid is cleaner than average */
	isGreen: boolean;
	/** Clean energy percentage */
	gridIntensity: number;
	/** Region code */
	region: string | null;
	/** Country name */
	countryName: string;
	/** Carbon intensity */
	carbonIntensity: number;
	/** Last updated timestamp */
	lastUpdated: string;
	/** Whether in development mode */
	developmentMode: boolean;
	/** Status message */
	statusMessage: string;
	/** CSS intensity class */
	intensityClass: IntensityClass;
}

// ============================================================================
// CONSTANTS
// ============================================================================

/**
 * Country code to name mapping
 */
const COUNTRY_NAMES: CountryNames = {
	NL: "Netherlands",
	US: "United States",
	DE: "Germany",
	FR: "France",
	GB: "United Kingdom",
	// Add more as needed
};

/**
 * Intensity color mapping for visual indicators
 */
const INTENSITY_COLORS: IntensityColors = {
	"very-green": "#22c55e",
	green: "#16a34a",
	yellow: "#eab308",
	orange: "#ea580c",
	red: "#dc2626",
};

/**
 * Maximum carbon intensity for percentage calculations
 */
const MAX_INTENSITY = 1000;

/**
 * Minimum carbon intensity for percentage calculations
 */
const MIN_INTENSITY = 0;

// ============================================================================
// FUNCTIONAL IMPLEMENTATION (class-free)
// ============================================================================

interface GridState {
	isGreen: boolean | null;
	gridIntensity: number | null;
	region: string | null;
	countryName: string | null;
	carbonIntensity: number | null;
	lastUpdated: string | null;
	developmentMode: boolean;
}

const state: GridState = {
	isGreen: null,
	gridIntensity: null,
	region: null,
	countryName: null,
	carbonIntensity: null,
	lastUpdated: null,
	developmentMode: false,
};

let apiUrl = "/wp-json/sustainable-theme/v1/grid-status";
let nonce = "";
let gridIntensityInstance: GridIntensity | null = null;

const getGridSettings = (): GridSettings =>
	window.sustainableThemeGridSettings || {
		enabled: false,
		apiUrl: "/wp-json/sustainable-theme/v1/grid-status",
	};

const isSettingsEnabled = (gridSettings: GridSettings): boolean => {
	return (
		gridSettings.enabled === true ||
		gridSettings.enabled === "1" ||
		gridSettings.enabled === 1
	);
};

const isAdminPage = (): boolean => window.location.href.includes("/wp-admin/");

const isLocalhost = (): boolean => {
	return (
		window.location.hostname.includes("localhost") ||
		window.location.hostname.includes(".local") ||
		window.location.hostname.includes("127.0.0.1")
	);
};

const shouldEnableGridAwareness = (gridSettings: GridSettings): boolean =>
	isSettingsEnabled(gridSettings) || isAdminPage() || isLocalhost();

const calculateIntensityPercentageFn = (carbonIntensity: number): number => {
	const percentage = Math.max(
		0,
		Math.min(
			100,
			((MAX_INTENSITY - carbonIntensity) / (MAX_INTENSITY - MIN_INTENSITY)) *
				100,
		),
	);
	return Math.round(percentage);
};

const getCountryNameFn = (region: string | null): string => {
	if (!region) return "Unknown";
	return COUNTRY_NAMES[region] || region;
};

const getStatusMessageFn = (): string => {
	if (state.isGreen === null) return "Checking grid status...";
	if (state.isGreen) return "Your local grid: Cleaner than average.";
	if (
		state.gridIntensity !== null &&
		state.gridIntensity >= 40 &&
		state.gridIntensity < 60
	) {
		return "Your local grid: About average.";
	}
	return "Your local grid: Dirtier than average.";
};

const getIntensityClassFn = (): IntensityClass => {
	const intensity = state.gridIntensity ?? 0;
	if (intensity >= 80) return "very-green";
	if (intensity >= 60) return "green";
	if (intensity >= 40) return "yellow";
	if (intensity >= 20) return "orange";
	return "red";
};

const getIntensityColorFn = (intensityClass: IntensityClass): string =>
	INTENSITY_COLORS[intensityClass] || "#6b7280";

const updateFromApiDataFn = (data: GridIntensityData): void => {
	state.isGreen = data.is_green;
	state.gridIntensity = data.grid_intensity;
	state.region = data.region || null;
	state.countryName = data.country_name;
	state.carbonIntensity = data.carbon_intensity;
	state.lastUpdated = data.last_updated;
};

const setFallbackDataFn = (): void => {
	state.isGreen = true;
	state.gridIntensity = 75;
	state.region = "NL";
	state.countryName = "Netherlands";
	state.carbonIntensity = 250;
	state.lastUpdated = new Date().toISOString();
	state.developmentMode = true;
	console.log("Using fallback development data");
};

const updateDataModeFn = (): void => {
	const currentMode = document.documentElement.dataset.mode;
	if (state.gridIntensity === null) return;
	if (state.gridIntensity < 50 && currentMode !== "low") {
		document.documentElement.dataset.mode = "low";
		console.log("Grid intensity is low, switching to low mode");
	} else if (state.gridIntensity >= 50 && currentMode === "low") {
		document.documentElement.dataset.mode = "medium";
		console.log("Grid intensity is good, switching to medium mode");
	}
};

const updateIntensityBarFn = (indicator: HTMLElement): void => {
	const intensityBar: HTMLElement | null =
		indicator.querySelector(".intensity-bar");
	if (intensityBar) {
		const intensityClass: IntensityClass = getIntensityClassFn();
		intensityBar.className = `intensity-bar ${intensityClass}`;
		const fill: HTMLElement | null = intensityBar.querySelector(
			".intensity-bar__fill",
		);
		if (fill) {
			fill.style.width = `${state.gridIntensity || 0}%`;
		} else {
			intensityBar.innerHTML = `<div class="intensity-bar__fill" style="width: ${state.gridIntensity || 0}%"></div>`;
		}
	}
};

const updateGridIndicatorFn = (): void => {
	const indicator: HTMLElement | null =
		document.getElementById("grid-indicator");
	if (!indicator) return;
	const statusTextEl: HTMLElement | null = indicator.querySelector(
		".grid-indicator__status",
	);
	if (statusTextEl) {
		let statusText: string = getStatusMessageFn();
		if (state.developmentMode) {
			statusText = `Development Mode: ${statusText}`;
		}
		statusTextEl.textContent = statusText;
	}
	const intensityClass: IntensityClass = getIntensityClassFn();
	indicator.className = `grid-indicator ${intensityClass}`;
	indicator.style.display = "inline-flex";
	updateIntensityBarFn(indicator);
};

const renderAdminStatsFn = (
	container: HTMLElement,
	stats: AdminStats,
): void => {
	const intensityColor: string = getIntensityColorFn(stats.intensityClass);
	container.innerHTML = `
      <div class="grid-stats-container">
        <div class="grid-stat-item">
          <strong>Status:</strong> 
          <span style="color: ${intensityColor}">${stats.statusMessage}</span>
        </div>
        <div class="grid-stat-item">
          <strong>Country:</strong> ${stats.countryName} (${stats.region})
        </div>
        <div class="grid-stat-item">
          <strong>Grid Intensity:</strong> ${stats.gridIntensity}% (${stats.carbonIntensity} gCO₂eq/kWh)
        </div>
        <div class="grid-stat-item">
          <strong>Last Updated:</strong> ${new Date(stats.lastUpdated).toLocaleString()}
        </div>
        ${stats.developmentMode ? '<div class="grid-stat-item development-notice"><strong>⚠️ Development Mode:</strong> Using sample data for testing</div>' : ""}
      </div>
    `;
};

const updateAdminStatsFn = (): void => {
	const adminStatsContainer: HTMLElement | null = document.getElementById(
		"grid-awareness-stats",
	);
	if (!adminStatsContainer) return;
	const stats: AdminStats = {
		enabled: true,
		isGreen: state.isGreen ?? false,
		gridIntensity: state.gridIntensity ?? 0,
		region: state.region,
		countryName: state.countryName ?? "Unknown",
		carbonIntensity: state.carbonIntensity ?? 0,
		lastUpdated: state.lastUpdated ?? new Date().toISOString(),
		developmentMode: state.developmentMode,
		statusMessage: getStatusMessageFn(),
		intensityClass: getIntensityClassFn(),
	};
	renderAdminStatsFn(adminStatsContainer, stats);
};

const updateBodyClassFn = (): void => {
	const gridSettings: GridSettings =
		window.sustainableThemeGridSettings || ({} as GridSettings);
	const isEnabled: boolean = isSettingsEnabled(gridSettings);
	const hasValidData: boolean =
		state.isGreen !== null && !state.developmentMode;
	const isNotDevelopmentMode: boolean = !state.developmentMode;

	document.body.classList.remove(
		"sustainable-theme-grid-very-green",
		"sustainable-theme-grid-green",
		"sustainable-theme-grid-yellow",
		"sustainable-theme-grid-orange",
		"sustainable-theme-grid-red",
		"sustainable-theme-grid-unknown",
	);

	console.log("updateBodyClass debug:", {
		isEnabled,
		hasValidData,
		isNotDevelopmentMode,
		isGreen: state.isGreen,
		gridIntensity: state.gridIntensity,
		developmentMode: state.developmentMode,
		rawEnabled: gridSettings.enabled,
	});

	if (
		isEnabled &&
		hasValidData &&
		isNotDevelopmentMode &&
		state.isGreen !== null
	) {
		const intensityClass: IntensityClass = getIntensityClassFn();
		const bodyClass: string = `sustainable-theme-grid-${intensityClass}`;
		document.body.classList.add(bodyClass);
		console.log(`✅ Added body class: ${bodyClass}`);
	} else {
		console.log("❌ Body class not added - requirements not met:", {
			enabled: isEnabled,
			hasValidData: hasValidData,
			notDevelopmentMode: isNotDevelopmentMode,
			isGreen: state.isGreen,
		});
	}
};

const getCurrentPositionFn = (): Promise<GeolocationPosition> =>
	new Promise((resolve, reject) => {
		if (!navigator.geolocation) {
			reject(new Error("Geolocation not supported"));
			return;
		}
		navigator.geolocation.getCurrentPosition(resolve, reject, {
			timeout: 5000,
			enableHighAccuracy: false,
		});
	});

const getUserZoneFn = async (): Promise<string | GeolocationCoords> => {
	try {
		const position: GeolocationPosition = await getCurrentPositionFn();
		return {
			lat: position.coords.latitude.toString(),
			lon: position.coords.longitude.toString(),
		};
	} catch (_error) {
		return "NL";
	}
};

const getIntensityFromLevelFn = (level: string): number => {
	switch (level) {
		case "low":
			return 85;
		case "moderate":
			return 50;
		case "high":
			return 15;
		default:
			return 50;
	}
};

const getCarbonIntensityFromLevelFn = (level: string): number => {
	switch (level) {
		case "low":
			return 150;
		case "moderate":
			return 400;
		case "high":
			return 800;
		default:
			return 400;
	}
};

const refreshGridStatus = async (): Promise<void> => {
	try {
		if (!gridIntensityInstance) return;
		const zone: string | GeolocationCoords = await getUserZoneFn();
		const result = (await gridIntensityInstance.check(
			zone,
		)) as GridIntensityResponse;
		if (result.status === "success") {
			if (result.gridAware !== undefined) {
				state.isGreen = !result.gridAware;
				state.gridIntensity = calculateIntensityPercentageFn(
					result.data?.carbonIntensity || 400,
				);
				state.carbonIntensity = result.data?.carbonIntensity || 400;
			} else if (result.level !== undefined) {
				state.isGreen = result.level === "low";
				state.gridIntensity = getIntensityFromLevelFn(result.level);
				state.carbonIntensity = getCarbonIntensityFromLevelFn(result.level);
			}
			state.region = result.region || null;
			state.countryName = getCountryNameFn(state.region);
			state.lastUpdated = new Date().toISOString();
			state.developmentMode = false;
		}
		updateDataModeFn();
		updateGridIndicatorFn();
		updateAdminStatsFn();
		updateBodyClassFn();
	} catch (error) {
		console.error("Failed to refresh grid status:", error);
	}
};

const initGridAwareness = async (): Promise<void> => {
	console.log("Grid awareness initializing...");
	console.log("Using backend REST API for secure API key handling");
	const gridSettings = getGridSettings();
	const isEnabled = shouldEnableGridAwareness(gridSettings);
	console.log("Grid awareness initialization check:", {
		settingsEnabled: isSettingsEnabled(gridSettings),
		isAdmin: isAdminPage(),
		isLocalhost: isLocalhost(),
		isEnabled,
		rawEnabled: gridSettings.enabled,
	});
	if (!isEnabled) {
		console.log("Grid awareness is disabled in theme settings");
		return;
	}
	apiUrl = gridSettings.apiUrl || "/wp-json/sustainable-theme/v1/grid-status";
	nonce = gridSettings.nonce || "";
	const gridIntensityOptions: GridIntensityOptions = {
		mode: "average",
		minimumIntensity: 400,
		dataProvider: "electricityMaps",
		apiKey: gridSettings.apiKey || "",
	};
	gridIntensityInstance = new GridIntensity(gridIntensityOptions);
	try {
		const response: Response = await fetch(apiUrl);
		const data: GridApiResponse = await response.json();
		if (data.success && data.data) {
			updateFromApiDataFn(data.data);
			state.developmentMode = data.development || false;
			console.log("Grid awareness data loaded:", {
				isGreen: state.isGreen,
				gridIntensity: state.gridIntensity,
				region: state.region,
				countryName: state.countryName,
				carbonIntensity: state.carbonIntensity,
			});
		} else {
			console.warn("Backend API check failed, using fallback");
			setFallbackDataFn();
		}
	} catch (error) {
		console.warn("Grid awareness initialization failed:", error);
		setFallbackDataFn();
	}
	updateDataModeFn();
	updateGridIndicatorFn();
	updateAdminStatsFn();
	updateBodyClassFn();
};

// ============================================================================
// INITIALIZATION
// ============================================================================

/**
 * Initialize grid awareness when DOM is loaded
 *
 * Creates a new GridAwarenessManager instance when the DOM is ready.
 * This ensures all DOM elements are available for manipulation.
 *
 * @since 1.0.0
 */
document.addEventListener("DOMContentLoaded", (): void => {
	initGridAwareness().catch((error) => {
		console.error("Grid awareness init failed:", error);
	});
});

// ============================================================================
// EXPORTS
// ============================================================================

export { initGridAwareness, refreshGridStatus };
export type {
	GridSettings,
	GridIntensityData,
	GridApiResponse,
	GridIntensityOptions,
	GridIntensityResponse,
	GeolocationCoords,
	IntensityClass,
	AdminStats,
};
