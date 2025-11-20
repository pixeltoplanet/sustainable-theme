import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import { Button, Notice } from "@wordpress/components";
import PageWrapper from "../components/PageWrapper";
import PageBody from "../components/PageBody";
import PageTitle from "../components/PageTitle";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";
import Spacer from "../components/Spacer";
import SustainabilitySettingsPanel from "../components/SustainabilitySettingsPanel";
import DatabaseCleanupPanel from "../components/DatabaseCleanupPanel";
import { getDefaultSettings, getModeSettings, hasSettingsChanged } from "../lib/settings-utils";
import { loadSettings, saveSettings, cleanupDatabase } from "../lib/api-utils";

export default function SustainabilityPage() {
	const [settings, setSettings] = useState(getDefaultSettings());
	const [isSaving, setIsSaving] = useState(false);
	const [saveMessage, setSaveMessage] = useState("");
	const [saveStatus, setSaveStatus] = useState(""); // 'success' or 'error'
	const [isCleaningDb, setIsCleaningDb] = useState(false);
	const [cleanupMessage, setCleanupMessage] = useState("");
	const [cleanupStatus, setCleanupStatus] = useState(""); // 'success' or 'error'
	const [originalSettings, setOriginalSettings] = useState(null);

	// Load settings on component mount
	useEffect(() => {
		const loadSettingsData = async () => {
			try {
				const data = await loadSettings();
					setSettings(data);
					setOriginalSettings(data);
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
					setSettings(result.settings);
					setOriginalSettings(result.settings);
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
		const modeSettings = getModeSettings(mode, settings);
		setSettings(modeSettings);
		// Don't update originalSettings here - let the user save to make it "official"
	};

	const handleSettingChange = (settingName, value) => {
		setSettings((prev) => ({
			...prev,
			[settingName]: value,
		}));
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
			</PageBody>
		</PageWrapper>
	);
}
