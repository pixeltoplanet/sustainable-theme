import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import { Button, Notice, Panel, PanelBody, TextControl } from "@wordpress/components";
import PageWrapper from "../components/PageWrapper";
import PageBody from "../components/PageBody";
import PageTitle from "../components/PageTitle";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";
import Spacer from "../components/Spacer";

const DEFAULT_SETTINGS = {
	rounded_card: "15px",
	rounded_image: "15px",
	rounded_button: "4px",
};

export default function DesignPage() {
	const [settings, setSettings] = useState(DEFAULT_SETTINGS);
	const [originalSettings, setOriginalSettings] = useState(null);
	const [isSaving, setIsSaving] = useState(false);
	const [saveMessage, setSaveMessage] = useState("");
	const [saveStatus, setSaveStatus] = useState("");

	useEffect(() => {
		const loadSettings = async () => {
			try {
				const response = await fetch("/wp-json/sustainable-theme/v1/design-settings", {
					headers: {
						"X-WP-Nonce": window.wpApiSettings?.nonce || "",
					},
				});

				if (!response.ok) {
					return;
				}

				const data = await response.json();
				const normalized = { ...DEFAULT_SETTINGS, ...data.settings };
				setSettings(normalized);
				setOriginalSettings(normalized);
			} catch (error) {
				console.error("Failed to load design settings:", error);
			}
		};

		loadSettings();
	}, []);

	const hasChanges =
		originalSettings !== null &&
		JSON.stringify(settings) !== JSON.stringify(originalSettings);

	const handleSave = async () => {
		setIsSaving(true);
		setSaveMessage("");
		setSaveStatus("");

		try {
			const response = await fetch("/wp-json/sustainable-theme/v1/design-settings", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": window.wpApiSettings?.nonce || "",
				},
				body: JSON.stringify({ settings }),
			});

			const data = await response.json();

			setTimeout(() => {
				setIsSaving(false);

				if (response.ok && data.success) {
					const normalized = { ...DEFAULT_SETTINGS, ...data.settings };
					setSettings(normalized);
					setOriginalSettings(normalized);
					setSaveMessage(__("Design settings saved successfully!", "sustainable-theme"));
					setSaveStatus("success");
				} else {
					setSaveMessage(
						data.message || __("Failed to save design settings.", "sustainable-theme"),
					);
					setSaveStatus("error");
				}

				setTimeout(() => {
					setSaveMessage("");
					setSaveStatus("");
				}, 4000);
			}, 500);
		} catch (error) {
			console.error("Failed to save design settings:", error);
			setIsSaving(false);
			setSaveMessage(__("An error occurred while saving design settings.", "sustainable-theme"));
			setSaveStatus("error");
		}
	};

	return (
		<PageWrapper>
			<PageHeader>
				<PageTitle>{__("Design Settings", "sustainable-theme")}</PageTitle>
			</PageHeader>
			<PageBody>
				{saveMessage && (
					<Notice status={saveStatus === "success" ? "success" : "error"} isDismissible={false}>
						{saveMessage}
					</Notice>
				)}

				<Panel header={__("Border radius tokens", "sustainable-theme")} className="sustainable-theme-panel">
					<PanelBody title={__("Global radius values", "sustainable-theme")} initialOpen={true}>
						<Text style={{ marginBottom: "16px" }}>
							{__(
								"These values output CSS custom properties on :root and sync to theme.json for the site editor. Use var(--rounded-card), var(--rounded-image), and var(--rounded-button) in patterns and blocks. Hardcoded radius values on individual blocks still take precedence.",
								"sustainable-theme",
							)}
						</Text>

						<TextControl
							label={__("Card radius (--rounded-card)", "sustainable-theme")}
							help={__("Used for cards, groups, and boxed surfaces.", "sustainable-theme")}
							value={settings.rounded_card}
							onChange={(value) => setSettings((prev) => ({ ...prev, rounded_card: value }))}
						/>

						<TextControl
							label={__("Image radius (--rounded-image)", "sustainable-theme")}
							help={__("Used for images and featured images in project grids.", "sustainable-theme")}
							value={settings.rounded_image}
							onChange={(value) => setSettings((prev) => ({ ...prev, rounded_image: value }))}
						/>

						<TextControl
							label={__("Button radius (--rounded-button)", "sustainable-theme")}
							help={__("Default button corner radius from theme.json.", "sustainable-theme")}
							value={settings.rounded_button}
							onChange={(value) => setSettings((prev) => ({ ...prev, rounded_button: value }))}
						/>
					</PanelBody>
				</Panel>

				<Spacer margin={4} />

				<Button
					variant="primary"
					className="sustainable-theme-button"
					onClick={handleSave}
					isBusy={isSaving}
					disabled={isSaving || !hasChanges}
				>
					{isSaving ? __("Saving…", "sustainable-theme") : __("Save design settings", "sustainable-theme")}
				</Button>
			</PageBody>
		</PageWrapper>
	);
}
