import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import { PanelBody, ToggleControl, TextControl } from "@wordpress/components";
import Text from "./Text";
import Heading from "./Heading";

export default function GridIntensityPanel({
	isEnabled,
	onToggleChange,
	apiKey,
	onApiKeyChange,
}) {
	const [gridAwarenessData, setGridAwarenessData] = useState(null);
	const [gridAwarenessLoading, setGridAwarenessLoading] = useState(true);

	// Fetch grid awareness data directly from API
	useEffect(() => {
		const fetchGridData = async () => {
			try {
				const response = await fetch(
					"/wp-json/sustainable-theme/v1/grid-status",
				);
				if (response.ok) {
					const data = await response.json();
					if (data.success && data.data) {
						setGridAwarenessData({
							intensity: data.data.grid_intensity,
							country: data.data.country_name,
							status: data.data.status_message,
							lastUpdated: new Date(data.data.last_updated).toLocaleString(),
							development: data.development,
						});
						setGridAwarenessLoading(false);
					}
				}
			} catch (error) {
				console.error("Failed to fetch grid awareness data:", error);
				setGridAwarenessLoading(false);
			}
		};

		if (isEnabled) {
			fetchGridData();
		}
	}, [isEnabled]);

	// Listen for grid awareness data updates from JavaScript
	useEffect(() => {
		const checkGridAwarenessData = () => {
			const statsContainer = document.getElementById("grid-awareness-stats");
			if (statsContainer?.innerHTML.includes("Grid Intensity:")) {
				// Extract data from the DOM
				const intensityMatch = statsContainer.innerHTML.match(
					/Grid Intensity:\s*(\d+)%/,
				);
				const countryMatch =
					statsContainer.innerHTML.match(/Country:\s*([^(]+)/);
				const statusMatch = statsContainer.innerHTML.match(
					/Status:\s*<span[^>]*>([^<]+)<\/span>/,
				);
				const lastUpdatedMatch = statsContainer.innerHTML.match(
					/Last Updated:\s*([^<]+)/,
				);
				const developmentMatch =
					statsContainer.innerHTML.includes("Development Mode:");

				if (intensityMatch && countryMatch && statusMatch) {
					setGridAwarenessData({
						intensity: intensityMatch[1],
						country: countryMatch[1].trim(),
						status: statusMatch[1],
						lastUpdated: lastUpdatedMatch
							? lastUpdatedMatch[1].trim()
							: "Unknown",
						development: developmentMatch,
					});
					setGridAwarenessLoading(false);
				}
			}
		};

		// Check immediately and then every 1 second for faster response
		checkGridAwarenessData();
		const interval = setInterval(checkGridAwarenessData, 1000);

		return () => clearInterval(interval);
	}, []);

	return (
		<PanelBody
			title={__(
				"Grid Awareness - Coming Soon",
				"sustainable-theme",
			)}
			initialOpen={false}
		>
			<Text style={{ marginBottom: "16px" }}>
				{__(
					"Grid awareness will adapt your website based on the carbon intensity of your local electricity grid. When renewable energy is high, your site will show more features. When it's low, it will go into eco-mode. This feature is coming soon!",
					"sustainable-theme",
				)}
			</Text>

			<div style={{ marginBottom: "20px" }}>
				<ToggleControl
					label={__("Enable Grid Awareness", "sustainable-theme")}
					checked={false}
					onChange={() => {}} // Disabled - no action
					disabled={true}
					help={__(
						"Grid awareness is coming soon! This feature will adapt your website based on local electricity grid conditions.",
						"sustainable-theme",
					)}
				/>
			</div>

			{/* API Key input is disabled - feature coming soon */}

			{!isEnabled && (
				<div style={{ marginTop: "16px" }}>
					<div style={{
						backgroundColor: "#fef3c7",
						border: "1px solid #f59e0b",
						borderRadius: "6px",
						padding: "16px",
						marginBottom: "12px"
					}}>
						<Text style={{ 
							fontWeight: "bold", 
							color: "#92400e",
							marginBottom: "8px"
						}}>
							🚧 {__("Coming Soon", "sustainable-theme")}
						</Text>
						<Text style={{ 
							fontStyle: "italic", 
							color: "#92400e",
							fontSize: "14px"
						}}>
							{__(
								"Grid awareness is currently in development. This feature will allow your website to adapt based on local electricity grid conditions, showing more features when renewable energy is high and going into eco-mode when it's low.",
								"sustainable-theme",
							)}
						</Text>
					</div>
					<Text style={{ fontStyle: "italic", color: "#6b7280" }}>
						{__(
							"Grid awareness is currently disabled. This feature will be available in a future update.",
							"sustainable-theme",
						)}
					</Text>
				</div>
			)}

			{/* Grid Status section is hidden - feature coming soon */}
		</PanelBody>
	);
}
