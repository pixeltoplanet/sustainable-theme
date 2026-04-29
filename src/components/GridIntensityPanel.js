import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import {
	PanelBody,
	ToggleControl,
	TextControl,
	RangeControl,
	Button,
	Notice,
} from "@wordpress/components";
import Text from "./Text";
import Heading from "./Heading";

const COMMON_ZONES = [
	{ code: "NL", name: "Netherlands" },
	{ code: "DE", name: "Germany" },
	{ code: "FR", name: "France" },
	{ code: "GB", name: "United Kingdom" },
	{ code: "ES", name: "Spain" },
	{ code: "IT", name: "Italy" },
	{ code: "SE", name: "Sweden" },
	{ code: "NO", name: "Norway" },
	{ code: "DK", name: "Denmark" },
	{ code: "BE", name: "Belgium" },
	{ code: "AT", name: "Austria" },
	{ code: "CH", name: "Switzerland" },
	{ code: "PL", name: "Poland" },
	{ code: "PT", name: "Portugal" },
	{ code: "FI", name: "Finland" },
	{ code: "IE", name: "Ireland" },
	{ code: "US", name: "United States" },
	{ code: "CA", name: "Canada" },
	{ code: "AU", name: "Australia" },
	{ code: "JP", name: "Japan" },
	{ code: "IN", name: "India" },
	{ code: "BR", name: "Brazil" },
];

export default function GridIntensityPanel({
	isEnabled,
	onToggleChange,
	apiKey,
	onApiKeyChange,
	zone,
	onZoneChange,
	cacheMinutes,
	onCacheMinutesChange,
}) {
	const [gridStatus, setGridStatus] = useState(null);
	const [isLoading, setIsLoading] = useState(false);
	const [testResult, setTestResult] = useState(null);
	const [isTesting, setIsTesting] = useState(false);

	useEffect(() => {
		if (!isEnabled) {
			setGridStatus(null);
			return;
		}

		const fetchStatus = async () => {
			setIsLoading(true);
			try {
				const response = await fetch(
					"/wp-json/sustainable-theme/v1/grid-status",
				);
				if (response.ok) {
					const data = await response.json();
					if (data.success) {
						setGridStatus(data.data);
					}
				}
			} catch (error) {
				console.error("Failed to fetch grid status:", error);
			}
			setIsLoading(false);
		};

		fetchStatus();
	}, [isEnabled]);

	const handleTestConnection = async () => {
		setIsTesting(true);
		setTestResult(null);

		try {
			const response = await fetch(
				"/wp-json/sustainable-theme/v1/grid-test",
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-WP-Nonce": window.wpApiSettings?.nonce || "",
					},
				},
			);

			const data = await response.json();
			setTestResult({
				success: data.success,
				message: data.message,
			});
		} catch (error) {
			setTestResult({
				success: false,
				message: __("Connection failed. Check your network.", "sustainable-theme"),
			});
		}

		setIsTesting(false);

		setTimeout(() => setTestResult(null), 5000);
	};

	const zoneName =
		COMMON_ZONES.find((z) => z.code === zone)?.name || zone || "Unknown";

	const levelColors = {
		low: "#22c55e",
		medium: "#f59e0b",
		high: "#ef4444",
	};

	return (
		<PanelBody
			title={__("Grid Awareness", "sustainable-theme")}
			initialOpen={false}
		>
			<Text style={{ marginBottom: "16px" }}>
				{__(
					"Grid awareness adapts your website based on the carbon intensity of the local electricity grid. When the grid is clean, visitors get the full experience. When it relies more on fossil fuels, page weight is reduced automatically.",
					"sustainable-theme",
				)}
			</Text>

			<ToggleControl
				label={__("Enable Grid Awareness", "sustainable-theme")}
				checked={isEnabled}
				onChange={onToggleChange}
				help={
					isEnabled
						? __(
								"Grid awareness is active. The top bar and body classes will be applied to your site.",
								"sustainable-theme",
							)
						: __(
								"Enable to show a grid status bar and adapt your site to electricity grid conditions.",
								"sustainable-theme",
							)
				}
			/>

			{isEnabled && (
				<div
					style={{
						display: "flex",
						flexDirection: "column",
						gap: "16px",
						marginTop: "16px",
					}}
				>
					<Heading level={4}>
						{__("API Configuration", "sustainable-theme")}
					</Heading>

					<TextControl
						label={__("Electricity Maps API Key", "sustainable-theme")}
						value={apiKey || ""}
						onChange={onApiKeyChange}
						type="password"
						help={
							<span>
								{__("Get a free key at ", "sustainable-theme")}
								<a
									href="https://www.electricitymaps.com/free-tier-api"
									target="_blank"
									rel="noopener noreferrer"
								>
									electricitymaps.com/free-tier-api
								</a>
							</span>
						}
					/>

					<div>
						<label
							htmlFor="grid-zone-select"
							style={{
								display: "block",
								marginBottom: "8px",
								fontWeight: 500,
								fontSize: "11px",
								textTransform: "uppercase",
							}}
						>
							{__("Zone", "sustainable-theme")}
						</label>
						<select
							id="grid-zone-select"
							value={zone || "NL"}
							onChange={(e) => onZoneChange(e.target.value)}
							style={{
								width: "100%",
								padding: "8px",
								borderRadius: "4px",
								border: "1px solid #8c8f94",
								fontSize: "14px",
							}}
						>
							{COMMON_ZONES.map((z) => (
								<option key={z.code} value={z.code}>
									{z.name} ({z.code})
								</option>
							))}
						</select>
						<p
							style={{
								fontSize: "12px",
								color: "#757575",
								marginTop: "6px",
							}}
						>
							{__(
								"The electricity grid zone for your server location. Find all zone codes at ",
								"sustainable-theme",
							)}
							<a
								href="https://docs.electricitymaps.com/coverage"
								target="_blank"
								rel="noopener noreferrer"
							>
								docs.electricitymaps.com/coverage
							</a>
						</p>
					</div>

					<RangeControl
						label={__("Cache Duration (minutes)", "sustainable-theme")}
						value={cacheMinutes || 15}
						onChange={onCacheMinutesChange}
						min={5}
						max={60}
						step={5}
						help={__(
							"How long to cache the grid intensity data before fetching fresh data from the API.",
							"sustainable-theme",
						)}
					/>

					{apiKey && (
						<div style={{ display: "flex", alignItems: "center", gap: "12px" }}>
							<Button
								isSecondary
								__next40pxDefaultSize
								onClick={handleTestConnection}
								isBusy={isTesting}
								disabled={isTesting}
							>
								{isTesting
									? __("Testing...", "sustainable-theme")
									: __("Test API Connection", "sustainable-theme")}
							</Button>
						</div>
					)}

					{testResult && (
						<Notice
							status={testResult.success ? "success" : "error"}
							isDismissible={false}
						>
							{testResult.message}
						</Notice>
					)}

					{gridStatus && (
						<div
							style={{
								backgroundColor: "#f9fafb",
								border: "1px solid #e5e7eb",
								borderRadius: "6px",
								padding: "16px",
							}}
						>
							<Heading level={4} style={{ marginBottom: "12px" }}>
								{__("Current Grid Status", "sustainable-theme")}
							</Heading>

							<div
								style={{
									display: "grid",
									gridTemplateColumns: "auto 1fr",
									gap: "6px 12px",
									fontSize: "13px",
								}}
							>
								<strong>{__("Zone:", "sustainable-theme")}</strong>
								<span>
									{gridStatus.zone_name} ({gridStatus.zone})
								</span>

								<strong>{__("Level:", "sustainable-theme")}</strong>
								<span
									style={{
										color: levelColors[gridStatus.level] || "#6b7280",
										fontWeight: 600,
										textTransform: "capitalize",
									}}
								>
									{gridStatus.level}
								</span>

								<strong>{__("Status:", "sustainable-theme")}</strong>
								<span>{gridStatus.message}</span>

								{gridStatus.datetime && (
									<>
										<strong>{__("Last Update:", "sustainable-theme")}</strong>
										<span>
											{new Date(gridStatus.datetime).toLocaleString()}
										</span>
									</>
								)}
							</div>
						</div>
					)}

					{isLoading && (
						<Text style={{ color: "#6b7280", fontStyle: "italic" }}>
							{__("Loading grid status...", "sustainable-theme")}
						</Text>
					)}
				</div>
			)}
		</PanelBody>
	);
}
