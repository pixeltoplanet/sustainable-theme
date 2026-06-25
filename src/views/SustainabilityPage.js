import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import { Button, Notice, Panel, PanelBody } from "@wordpress/components";
import PageWrapper from "../components/PageWrapper";
import PageBody from "../components/PageBody";
import PageTitle from "../components/PageTitle";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";
import Spacer from "../components/Spacer";
import SustainabilitySettingsPanel from "../components/SustainabilitySettingsPanel";
import DatabaseCleanupPanel from "../components/DatabaseCleanupPanel";
import { getDefaultSettings, getModeSettings, hasSettingsChanged } from "../lib/settings-utils";
import { loadSettings, saveSettings, cleanupDatabase, testSettings } from "../lib/api-utils";

export default function SustainabilityPage() {
	const [settings, setSettings] = useState(getDefaultSettings());
	const [isSaving, setIsSaving] = useState(false);
	const [saveMessage, setSaveMessage] = useState("");
	const [saveStatus, setSaveStatus] = useState(""); // 'success' or 'error'
	const [isCleaningDb, setIsCleaningDb] = useState(false);
	const [cleanupMessage, setCleanupMessage] = useState("");
	const [cleanupStatus, setCleanupStatus] = useState(""); // 'success' or 'error'
	const [originalSettings, setOriginalSettings] = useState(null);
	const [isTesting, setIsTesting] = useState(false);
	const [testResults, setTestResults] = useState(null);
	const [testMessage, setTestMessage] = useState("");

	// Load settings on component mount
	useEffect(() => {
		const loadSettingsData = async () => {
			try {
				const data = await loadSettings();
				// Normalize settings to ensure all properties exist
				const normalizedData = { ...getDefaultSettings(), ...data };
				setSettings(normalizedData);
				setOriginalSettings(normalizedData);
			} catch (error) {
				console.error("Failed to load settings:", error);
			}
		};

		loadSettingsData();
	}, []);

	const handleSave = async () => {
		setIsSaving(true);
		setSaveMessage("");
		setSaveStatus("");

		try {
			const result = await saveSettings(settings);

			// Show loading for 1000ms before showing result
			setTimeout(() => {
				setIsSaving(false);

				if (result.success) {
					setSaveMessage(result.message);
					setSaveStatus("success");
					// Normalize saved settings to ensure all properties exist
					const normalizedSaved = { ...getDefaultSettings(), ...result.settings };
					setSettings(normalizedSaved);
					setOriginalSettings(normalizedSaved);
				} else {
					setSaveMessage(result.message);
					setSaveStatus("error");
				}

				// Clear the message after 4 seconds
				setTimeout(() => {
					setSaveMessage("");
					setSaveStatus("");
				}, 4000);
			}, 1000);
		} catch (error) {
			console.error("Failed to save settings:", error);

			// Show loading for 1000ms before showing error
			setTimeout(() => {
				setIsSaving(false);
				setSaveMessage(
					__("An error occurred while saving settings.", "sustainable"),
				);
				setSaveStatus("error");

				// Clear the message after 4 seconds
				setTimeout(() => {
					setSaveMessage("");
					setSaveStatus("");
				}, 4000);
			}, 1000);
		}
	};

	const handleDatabaseCleanup = async () => {
		setIsCleaningDb(true);
		setCleanupMessage("");
		setCleanupStatus("");

		try {
			const result = await cleanupDatabase();

			// Show loading for 1000ms before showing result
			setTimeout(() => {
				setIsCleaningDb(false);

				if (result.success) {
					setCleanupMessage(result.message);
					setCleanupStatus("success");
				} else {
					setCleanupMessage(result.message);
					setCleanupStatus("error");
				}

				// Clear the message after 4 seconds
				setTimeout(() => {
					setCleanupMessage("");
					setCleanupStatus("");
				}, 4000);
			}, 1000);
		} catch (error) {
			console.error("Failed to clean up database:", error);

			// Show loading for 1000ms before showing error
			setTimeout(() => {
				setIsCleaningDb(false);
				setCleanupMessage(
					__(
						"An error occurred while cleaning up the database.",
						"sustainable-theme",
					),
				);
				setCleanupStatus("error");

				// Clear the message after 4 seconds
				setTimeout(() => {
					setCleanupMessage("");
					setCleanupStatus("");
				}, 4000);
			}, 1000);
		}
	};

	const handleModeChange = (mode) => {
		// Get the predefined settings for this mode
		// Preserve grid awareness settings and API key when switching modes
		const currentGridSettings = {
			use_grid_awareness: settings.use_grid_awareness,
			electricity_maps_api_key: settings.electricity_maps_api_key || "",
		};
		
		const modeSettings = getModeSettings(mode, settings);
		// Merge mode settings with preserved grid settings
		const updatedSettings = {
			...modeSettings,
			...currentGridSettings,
		};
		
		setSettings(updatedSettings);
		// Don't update originalSettings here - let the user save to make it "official"
	};

	const handleSettingChange = (settingName, value) => {
		setSettings((prev) => {
			const updated = {
				...prev,
				[settingName]: value,
			};
			// If manually changing a setting (except grid awareness which is allowed in any mode)
			// and not in custom mode, switch to custom mode
			const gridAwarenessSettings = ["use_grid_awareness", "electricity_maps_api_key"];
			if (prev.sustainability_mode !== "custom" && !gridAwarenessSettings.includes(settingName)) {
				updated.sustainability_mode = "custom";
			}
			return updated;
		});
	};

	const handleTestSettings = async () => {
		setIsTesting(true);
		setTestMessage("");
		setTestResults(null);

		try {
			const result = await testSettings();

			setTimeout(() => {
				setIsTesting(false);

				if (result.success) {
					setTestResults(result);
					setTestMessage(
						__(
							`Tests completed: ${result.summary.passed} passed, ${result.summary.partial} partial, ${result.summary.not_tested} not tested`,
							"sustainable-theme",
						),
					);
				} else {
					setTestMessage(result.message || __("Failed to run tests.", "sustainable-theme"));
				}
			}, 500);
		} catch (error) {
			console.error("Failed to test settings:", error);
			setTimeout(() => {
				setIsTesting(false);
				setTestMessage(__("An error occurred while testing settings.", "sustainable-theme"));
			}, 500);
		}
	};


	return (
		<PageWrapper>
			<PageHeader>
				<PageTitle>
					{__("Sustainability", "sustainable-theme")}
				</PageTitle>
				<Text >
					{__(
						"You choose how much impact you want to have on the environment. We handle the rest.",
						"sustainable-theme",
					)}
				</Text>
			</PageHeader>

			<PageBody>
				{saveMessage && (
					<>
						<Spacer margin={4} />
						<Notice
							status={saveStatus}
							isDismissible={false}
							style={{ marginBottom: "20px" }}
						>
							{saveMessage}
						</Notice>
						<Spacer margin={4} />
					</>
				)}

				<SustainabilitySettingsPanel
					settings={settings}
					onSettingChange={handleSettingChange}
					onModeChange={handleModeChange}
					/>
					<Spacer margin={4} />
				
					<Button
						__next40pxDefaultSize
						variant="primary"
						onClick={handleSave}
						isBusy={isSaving}
					disabled={isSaving || !hasSettingsChanged(settings, originalSettings)}
					className={`sustainable-theme-button ${!hasSettingsChanged(settings, originalSettings) && "is-sustainable-theme-button--disabled"}`}
					>
						{isSaving
							? __("Saving...", "sustainable-theme")
							: __("Save changes", "sustainable-theme")}
					</Button>

				<Spacer margin={12} />

				<DatabaseCleanupPanel
					onCleanup={handleDatabaseCleanup}
					isCleaningDb={isCleaningDb}
					cleanupMessage={cleanupMessage}
					cleanupStatus={cleanupStatus}
				/>

				<Spacer margin={12} />

				<Panel
					header={__("Test Settings", "sustainable-theme")}
					className="sustainable-theme-panel"
				>
					<PanelBody>
						<Text>
							{__(
								"Run automated tests to verify all sustainability settings are working correctly.",
								"sustainable-theme",
							)}
						</Text>
						<Spacer margin={4} />
						<Button
							__next40pxDefaultSize
							variant="secondary"
							onClick={handleTestSettings}
							isBusy={isTesting}
							disabled={isTesting}
						>
							{isTesting
								? __("Running tests...", "sustainable-theme")
								: __("Run Tests", "sustainable-theme")}
						</Button>

						{testMessage && (
							<>
								<Spacer margin={4} />
								<Notice
									status={testResults ? "success" : "error"}
									isDismissible={false}
								>
									{testMessage}
								</Notice>
							</>
						)}

						{testResults && testResults.summary && (
							<>
								<Spacer margin={4} />
								<div
									style={{
										padding: "16px",
										backgroundColor: "#f0f6fc",
										borderRadius: "4px",
										border: "1px solid #c3dafe",
									}}
								>
									<Text style={{ margin: 0, fontWeight: "bold" }}>
										{__("Test Summary", "sustainable-theme")}
									</Text>
									<Text style={{ marginTop: "8px", marginBottom: 0 }}>
										{__("Total:", "sustainable-theme")} {testResults.summary.total} |{" "}
										{__("Passed:", "sustainable-theme")}{" "}
										<span style={{ color: "#00a32a" }}>
											{testResults.summary.passed}
										</span>{" "}
										| {__("Partial:", "sustainable-theme")}{" "}
										<span style={{ color: "#dba617" }}>
											{testResults.summary.partial}
										</span>{" "}
										| {__("Not Tested:", "sustainable-theme")}{" "}
										<span style={{ color: "#757575" }}>
											{testResults.summary.not_tested}
										</span>
									</Text>
									<Text style={{ marginTop: "8px", marginBottom: 0 }}>
										{__("Success Rate:", "sustainable-theme")}{" "}
										<strong>{testResults.summary.success_rate}%</strong>
									</Text>
								</div>

								{testResults.results && (
									<>
										<Spacer margin={4} />
										<details style={{ marginTop: "16px" }}>
											<summary style={{ cursor: "pointer", fontWeight: "bold" }}>
												{__("View Detailed Results", "sustainable-theme")}
											</summary>
											<div
												style={{
													marginTop: "16px",
													maxHeight: "400px",
													overflow: "auto",
													border: "1px solid #ddd",
													padding: "12px",
													borderRadius: "4px",
												}}
											>
												{Object.entries(testResults.results).map(
													([setting, result]) => (
														<div
															key={setting}
															style={{
																padding: "8px",
																marginBottom: "8px",
																borderLeft: `3px solid ${
																	result.status === "pass"
																		? "#00a32a"
																		: result.status === "partial"
																			? "#dba617"
																			: "#757575"
																}`,
																backgroundColor: "#f9f9f9",
															}}
														>
															<Text style={{ margin: 0, fontWeight: "bold" }}>
																{setting}
															</Text>
															<Text
																style={{
																	margin: "4px 0 0 0",
																	fontSize: "13px",
																	color:
																		result.status === "pass"
																			? "#00a32a"
																			: result.status === "partial"
																				? "#dba617"
																				: "#757575",
																}}
															>
																{result.message}
															</Text>
														</div>
													),
												)}
											</div>
										</details>
									</>
								)}
							</>
						)}
					</PanelBody>
				</Panel>
			</PageBody>
		</PageWrapper>
	);
}
