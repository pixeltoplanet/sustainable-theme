import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import {
	Panel,
	PanelBody,
	Button,
	Notice,
	ToggleControl,
	RangeControl,
	TextControl,
} from "@wordpress/components";
import PageWrapper from "../components/PageWrapper";
import PageBody from "../components/PageBody";
import PageTitle from "../components/PageTitle";
import SutainabilityModeSelector from "../components/SutainabilityModeSelector";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";
import Heading from "../components/Heading";
import Spacer from "../components/Spacer";
import GridIntensityPanel from "../components/GridIntensityPanel";

export default function AdminPage() {
	const [settings, setSettings] = useState({
		sustainability_mode: "base",
		dequeue_non_sustainable: false,
		use_grid_awareness: false,
		electricity_maps_api_key: "",
		grid_awareness_zone: "NL",
		grid_awareness_cache_minutes: 15,
		grid_awareness_image_mode: "low-res",
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
		disable_file_editing: false,
		reduce_heartbeat_frequency: false,
		disable_gravatar: false,
		remove_capital_p_dangit: false,
		disable_automatic_updates: false,
		remove_theme_editor: false,
		// Lazy loading settings
		enable_lazy_loading: false,
		above_fold_image_limit: 2,
		// Image optimization settings
		enable_image_optimization: false,
		remove_default_image_sizes: false,
	});
	const [isSaving, setIsSaving] = useState(false);
	const [saveMessage, setSaveMessage] = useState("");
	const [saveStatus, setSaveStatus] = useState(""); // 'success' or 'error'
	const [isCleaningDb, setIsCleaningDb] = useState(false);
	const [cleanupMessage, setCleanupMessage] = useState("");
	const [cleanupStatus, setCleanupStatus] = useState(""); // 'success' or 'error'
	const [isGeneratingBlur, setIsGeneratingBlur] = useState(false);
	const [blurMessage, setBlurMessage] = useState("");
	const [blurStatus, setBlurStatus] = useState("");
	const [originalSettings, setOriginalSettings] = useState(null);

	// Load settings on component mount
	useEffect(() => {
		const loadSettings = async () => {
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
					// Merge with default state to ensure all settings are present
					const mergedSettings = {
						...settings,
						...data,
					};
					setSettings(mergedSettings);
					// Store original settings for comparison
					setOriginalSettings(mergedSettings);
				}
			} catch (error) {
				console.error("Failed to load settings:", error);
			}
		};

		loadSettings();
	}, []);

	const handleSave = async () => {
		setIsSaving(true);
		setSaveMessage("");
		setSaveStatus("");

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

			// Show loading for 1000ms before showing result
			setTimeout(() => {
				setIsSaving(false);

				if (response.ok && data.success) {
					setSaveMessage(__("Settings saved successfully!", "sustainable"));
					setSaveStatus("success");
					setSettings(data.settings);
					// Update original settings to reflect the saved state
					setOriginalSettings(data.settings);
				} else {
					setSaveMessage(
						data.message || __("Failed to save settings.", "sustainable"),
					);
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
			const response = await fetch(
				"/wp-json/sustainable-theme/v1/database/cleanup",
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-WP-Nonce": window.wpApiSettings?.nonce || "",
					},
				},
			);

			const data = await response.json();

			// Show loading for 1000ms before showing result
			setTimeout(() => {
				setIsCleaningDb(false);

				if (response.ok && data.success) {
					setCleanupMessage(
						__("Database cleaned up successfully!", "sustainable-theme"),
					);
					setCleanupStatus("success");
				} else {
					setCleanupMessage(
						data.message ||
							__("Failed to clean up database.", "sustainable-theme"),
					);
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

	const handleGenerateBlurImages = async () => {
		setIsGeneratingBlur(true);
		setBlurMessage("");
		setBlurStatus("");

		try {
			const response = await fetch(
				"/wp-json/sustainable-theme/v1/images/generate-blurred",
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-WP-Nonce": window.wpApiSettings?.nonce || "",
					},
				},
			);

			const data = await response.json();

			setTimeout(() => {
				setIsGeneratingBlur(false);

				if (response.ok && data.success) {
					setBlurMessage(data.message);
					setBlurStatus("success");
				} else {
					setBlurMessage(
						data.message ||
							__(
								"Failed to generate blurred images.",
								"sustainable-theme",
							),
					);
					setBlurStatus("error");
				}

				setTimeout(() => {
					setBlurMessage("");
					setBlurStatus("");
				}, 6000);
			}, 1000);
		} catch (error) {
			console.error("Failed to generate blurred images:", error);

			setTimeout(() => {
				setIsGeneratingBlur(false);
				setBlurMessage(
					__(
						"An error occurred while generating blurred images.",
						"sustainable-theme",
					),
				);
				setBlurStatus("error");

				setTimeout(() => {
					setBlurMessage("");
					setBlurStatus("");
				}, 6000);
			}, 1000);
		}
	};

	const handleModeChange = (mode) => {
		// Get the predefined settings for this mode
		const modeSettings = getModeSettings(mode);
		setSettings(modeSettings);
		// Update original settings to reflect the mode change
		setOriginalSettings(modeSettings);
	};

	const handleSettingChange = (settingName, value) => {
		setSettings((prev) => ({
			...prev,
			[settingName]: value,
		}));
	};

	// Check if settings have changed from original
	const hasSettingsChanged = () => {
		if (!originalSettings) return false;
		
		// Deep comparison of settings objects
		return JSON.stringify(settings) !== JSON.stringify(originalSettings);
	};

	const getModeSettings = (mode) => {
		const baseSettings = {
			sustainability_mode: mode,
			dequeue_non_sustainable: false,
			use_grid_awareness: false,
			electricity_maps_api_key: "",
			grid_awareness_zone: "NL",
			grid_awareness_cache_minutes: 15,
			grid_awareness_image_mode: "low-res",
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
			disable_file_editing: true,
			reduce_heartbeat_frequency: false,
			disable_gravatar: false,
			remove_capital_p_dangit: true,
			disable_automatic_updates: false,
			remove_theme_editor: true,
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
					use_grid_awareness: settings.use_grid_awareness,
					electricity_maps_api_key: settings.electricity_maps_api_key || "",
					grid_awareness_zone: settings.grid_awareness_zone || "NL",
					grid_awareness_cache_minutes: settings.grid_awareness_cache_minutes || 15,
					grid_awareness_image_mode: settings.grid_awareness_image_mode || "low-res",
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
					use_grid_awareness: settings.use_grid_awareness,
					electricity_maps_api_key: settings.electricity_maps_api_key || "",
					grid_awareness_zone: settings.grid_awareness_zone || "NL",
					grid_awareness_cache_minutes: settings.grid_awareness_cache_minutes || 15,
					grid_awareness_image_mode: settings.grid_awareness_image_mode || "low-res",
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
					disable_file_editing: true,
					reduce_heartbeat_frequency: true,
					disable_gravatar: true,
					remove_capital_p_dangit: true,
					disable_automatic_updates: true,
					remove_theme_editor: true,
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
					...settings,
					sustainability_mode: "custom",
				};
			default:
				return baseSettings;
		}
	};

	return (
		<PageWrapper>
			<PageHeader>
				<PageTitle>
					{__("The Sustainable Theme", "sustainable-theme")}
				</PageTitle>
				<Text hasMaxWidth>
					{__(
						"The Sustainable Theme allows you to create a sustainable website with the smallest possible carbon footprint.",
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

				<Panel
					header={__("Sustainability settings", "sustainable-theme")}
					className="sustainable-theme-panel"
				>
					<PanelBody
						title={__(
							"How sustainable do you want your website to be?",
							"sustainable-theme",
						)}
						initialOpen={false}
					>
						<SutainabilityModeSelector
							value={settings.sustainability_mode}
							onChange={handleModeChange}
						/>
						<PanelBody
							title={__(
								"Sustainability Settings Overview",
								"sustainable-theme",
							)}
							initialOpen={false}
						>
							<div style={{ marginBottom: "16px" }}>
								<Text>
									<strong>
										{__("Sustainability Mode:", "sustainable-theme")}
									</strong>{" "}
									{settings.sustainability_mode === "base"
										? __("Sustainable", "sustainable-theme")
										: settings.sustainability_mode === "super"
											? __("Super Sustainable", "sustainable-theme")
											: __("Custom", "sustainable-theme")}
								</Text>
								{settings.sustainability_mode !== "custom" && (
									<Text
										style={{
											fontSize: "12px",
											color: "#666",
											marginTop: "8px",
										}}
									>
										{__(
											"Switch to Custom mode to modify individual settings below.",
											"sustainable-theme",
										)}
									</Text>
								)}
							</div>

							<div
								style={{
									display: "flex",
									flexDirection: "column",
									gap: "16px",
								}}
							>
								<Heading level={4}>
									{__("Core WordPress Features", "sustainable-theme")}
								</Heading>

								<ToggleControl
									label={__(
										"Remove Emoji Support - Makes pages load faster",
										"sustainable-theme",
									)}
									checked={settings.disable_emojis}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_emojis", value)
									}
									help={__(
										"WordPress loads extra files to show emojis (😀🎉). Removing these saves energy and makes your site faster. Most people can see emojis without these files anyway.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove Video Previews - Saves bandwidth",
										"sustainable-theme",
									)}
									checked={settings.remove_embeds}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_embeds", value)
									}
									help={__(
										"When you paste a YouTube or Twitter link, WordPress tries to show a preview. This feature uses extra code and server resources. Disabling it makes your site lighter.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove Extra Website Info - Cleaner code",
										"sustainable-theme",
									)}
									checked={settings.remove_header_metadata}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_header_metadata", value)
									}
									help={__(
										"WordPress adds hidden information to every page that most visitors never see. Removing this unnecessary code reduces the size of each page.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Stop Self-Notifications - Reduces server work",
										"sustainable-theme",
									)}
									checked={settings.disable_self_pingbacks}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_self_pingbacks", value)
									}
									help={__(
										"When you link to your own posts, WordPress tries to notify itself. This creates unnecessary work for your server. Turning this off saves energy.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove Old Code Support - Modern browsers only",
										"sustainable-theme",
									)}
									checked={settings.remove_jquery_migrate}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_jquery_migrate", value)
									}
									help={__(
										"WordPress includes extra code to support very old websites. Since most people use modern browsers, removing this old code makes your site faster.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove Unnecessary Scripts - Minimal code only",
										"sustainable-theme",
									)}
									checked={settings.dequeue_non_sustainable}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("dequeue_non_sustainable", value)
									}
									help={__(
										"Removes JavaScript files that aren't essential for your website to work. This makes pages load faster and uses less energy.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove RSS Feeds - No automatic updates",
										"sustainable-theme",
									)}
									checked={settings.disable_rss_feed}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_rss_feed", value)
									}
									help={__(
										"RSS feeds let people automatically get updates when you post. If you don't need this feature, removing it reduces server work and saves energy.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove API Links - Less code in pages",
										"sustainable-theme",
									)}
									checked={settings.remove_rest_output}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_rest_output", value)
									}
									help={__(
										"WordPress adds links for apps and developers in every page. If you don't use these features, removing them makes pages smaller and faster.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Block Remote Publishing - Better security",
										"sustainable-theme",
									)}
									checked={settings.disable_xmlrpc}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_xmlrpc", value)
									}
									help={__(
										"XML-RPC lets you publish posts from apps. If you only write posts from your website, disabling this improves security and reduces server load.",
										"sustainable-theme",
									)}
								/>

								<Heading level={4} style={{ marginTop: "24px" }}>
									{__("Performance Optimizations", "sustainable-theme")}
								</Heading>

								<ToggleControl
									label={__(
										"Remove Shortlinks - Cleaner HTML",
										"sustainable-theme",
									)}
									checked={settings.remove_shortlinks}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_shortlinks", value)
									}
									help={__(
										"Removes unnecessary shortlink headers and meta tags to reduce HTML overhead.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove Query Strings - Better caching",
										"sustainable-theme",
									)}
									checked={settings.remove_query_strings}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_query_strings", value)
									}
									help={__(
										"Removes version parameters from static resources for improved CDN and browser caching.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove DNS Prefetch - Fewer connections",
										"sustainable-theme",
									)}
									checked={settings.remove_dns_prefetch}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_dns_prefetch", value)
									}
									help={__(
										"Eliminates DNS prefetch hints that create unnecessary network connections and consume resources.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove WordPress Version - Security & efficiency",
										"sustainable-theme",
									)}
									checked={settings.remove_wp_version}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_wp_version", value)
									}
									help={__(
										"Hides WordPress version information from HTML output for both security and reduced processing overhead.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Enable Lazy Loading - Load images on demand",
										"sustainable-theme",
									)}
									checked={settings.enable_lazy_loading}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("enable_lazy_loading", value)
									}
									help={__(
										"Uses native browser lazy loading to only load images when they're about to enter the viewport. Saves bandwidth and improves page load speed.",
										"sustainable-theme",
									)}
								/>

								{settings.enable_lazy_loading && (
									<RangeControl
										label={__(
											`Above-fold images: ${settings.above_fold_image_limit} loaded eagerly`,
											"sustainable-theme",
										)}
										value={settings.above_fold_image_limit || 2}
										disabled={settings.sustainability_mode !== "custom"}
										onChange={(value) =>
											handleSettingChange("above_fold_image_limit", value)
										}
										min={1}
										max={5}
										help={__(
											"Number of images at the top of the page to load immediately (not lazy). Higher numbers ensure faster visible content but use more bandwidth.",
											"sustainable-theme",
										)}
									/>
								)}

								<ToggleControl
									label={__(
										"Enable Image Optimization - Responsive sizes",
										"sustainable-theme",
									)}
									checked={settings.enable_image_optimization}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("enable_image_optimization", value)
									}
									help={__(
										"Creates optimized image sizes for different screen sizes. Reduces bandwidth usage and improves loading speed.",
										"sustainable-theme",
									)}
								/>

								{settings.enable_image_optimization && (
									<ToggleControl
										label={__(
											"Remove Default Image Sizes",
											"sustainable-theme",
										)}
										checked={settings.remove_default_image_sizes}
										disabled={settings.sustainability_mode !== "custom"}
										onChange={(value) =>
											handleSettingChange("remove_default_image_sizes", value)
										}
										help={__(
											"Removes WordPress default image sizes (medium, large, full) to save storage space and reduce processing.",
											"sustainable-theme",
										)}
									/>
								)}

								<Heading level={4} style={{ marginTop: "24px" }}>
									{__("Frontend Optimizations", "sustainable-theme")}
								</Heading>

								<ToggleControl
									label={__(
										"Remove Dashicons Frontend - 24KB saved",
										"sustainable-theme",
									)}
									checked={settings.disable_dashicons_frontend}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_dashicons_frontend", value)
									}
									help={__(
										"Removes the Dashicons CSS file (~24KB) from frontend pages where admin icons aren't needed.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Replace Gravatar - SVG placeholders",
										"sustainable-theme",
									)}
									checked={settings.disable_gravatar}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_gravatar", value)
									}
									help={__(
										"Replaces external Gravatar requests with lightweight, privacy-friendly SVG placeholders.",
										"sustainable-theme",
									)}
								/>

								<Heading level={4} style={{ marginTop: "24px" }}>
									{__("Server Resource Management", "sustainable-theme")}
								</Heading>

								<ToggleControl
									label={__(
										"Disable Heartbeat - Maximum efficiency",
										"sustainable-theme",
									)}
									checked={settings.disable_heartbeat}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_heartbeat", value)
									}
									help={__(
										"Completely disables WordPress heartbeat to eliminate constant server polling and save significant resources.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Reduce Heartbeat Frequency - Balanced approach",
										"sustainable-theme",
									)}
									checked={settings.reduce_heartbeat_frequency}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("reduce_heartbeat_frequency", value)
									}
									help={__(
										"Reduces heartbeat polling from every 15-60 seconds to every 2 minutes, significantly reducing server load.",
										"sustainable-theme",
									)}
								/>

								{settings.limit_post_revisions !== false && (
									<RangeControl
										label={__(
											`Limit Post Revisions - ${settings.limit_post_revisions} max`,
											"sustainable-theme",
										)}
										value={settings.limit_post_revisions || 0}
										disabled={settings.sustainability_mode !== "custom"}
										onChange={(value) =>
											handleSettingChange("limit_post_revisions", value)
										}
										min={0}
										max={10}
										help={__(
											`Database bloat prevention by limiting post revisions to ${settings.limit_post_revisions}. Unlimited revisions can slow down your site over time.`,
											"sustainable-theme",
										)}
									/>
								)}

								<ToggleControl
									label={__(
										"Enable Post Revision Limiting",
										"sustainable-theme",
									)}
									checked={settings.limit_post_revisions !== false}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange(
											"limit_post_revisions",
											value ? 3 : false,
										)
									}
									help={__(
										"Enable or disable post revision limiting entirely.",
										"sustainable-theme",
									)}
								/>

								<Heading level={4} style={{ marginTop: "24px" }}>
									{__("Feature Removal", "sustainable-theme")}
								</Heading>

								<ToggleControl
									label={__(
										"Disable Comments - Complete removal",
										"sustainable-theme",
									)}
									checked={settings.disable_comments}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_comments", value)
									}
									help={__(
										"Completely removes the comment system, including admin pages, database queries, and frontend processing.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Remove WordPress Auto-corrections",
										"sustainable-theme",
									)}
									checked={settings.remove_capital_p_dangit}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_capital_p_dangit", value)
									}
									help={__(
										'Disables WordPress automatic text corrections (like "Wordpress" → "WordPress").',
										"sustainable-theme",
									)}
								/>

								<Heading level={4} style={{ marginTop: "24px" }}>
									{__("Security & Maintenance", "sustainable-theme")}
								</Heading>

								<ToggleControl
									label={__(
										"Disable File Editing - Security enhancement",
										"sustainable-theme",
									)}
									checked={settings.disable_file_editing}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_file_editing", value)
									}
									help={__(
										"Prevents file editing through WordPress admin, improving security and reducing admin overhead.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__("Remove Theme Editor", "sustainable-theme")}
									checked={settings.remove_theme_editor}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("remove_theme_editor", value)
									}
									help={__(
										"Completely removes the theme editor from the admin area.",
										"sustainable-theme",
									)}
								/>

								<ToggleControl
									label={__(
										"Disable Auto Updates - Manual control",
										"sustainable-theme",
									)}
									checked={settings.disable_automatic_updates}
									disabled={settings.sustainability_mode !== "custom"}
									onChange={(value) =>
										handleSettingChange("disable_automatic_updates", value)
									}
									help={__(
										"Disables automatic updates to reduce background processing. Requires manual security monitoring.",
										"sustainable-theme",
									)}
								/>
							</div>
						</PanelBody>
					</PanelBody>
					<GridIntensityPanel
						isEnabled={settings.use_grid_awareness}
						onToggleChange={(value) =>
							handleSettingChange("use_grid_awareness", value)
						}
						apiKey={settings.electricity_maps_api_key}
						onApiKeyChange={(value) =>
							handleSettingChange("electricity_maps_api_key", value)
						}
						zone={settings.grid_awareness_zone}
						onZoneChange={(value) =>
							handleSettingChange("grid_awareness_zone", value)
						}
						cacheMinutes={settings.grid_awareness_cache_minutes}
						onCacheMinutesChange={(value) =>
							handleSettingChange("grid_awareness_cache_minutes", value)
						}
						imageMode={settings.grid_awareness_image_mode}
						onImageModeChange={(value) =>
							handleSettingChange("grid_awareness_image_mode", value)
						}
					/>
					<Spacer margin={4} />
					<Button
						__next40pxDefaultSize
						variant="primary"
						onClick={handleSave}
						isBusy={isSaving}
						disabled={isSaving || !hasSettingsChanged()}
						style={{ marginLeft: "16px", marginBottom: "16px" }}
						className={`sustainable-theme-button ${!hasSettingsChanged() && "is-sustainable-theme-button--disabled"}`}
					>
						{isSaving
							? __("Saving...", "sustainable-theme")
							: __("Save changes", "sustainable-theme")}
					</Button>
				</Panel>

				<Spacer margin={12} />

				<Panel
					header={__("Database cleanup", "sustainable-theme")}
					className="sustainable-theme-panel"
				>
					<PanelBody
						title={__("Remove old data", "sustainable-theme")}
						initialOpen={false}
					>
						{cleanupMessage && (
							<>
								<Notice status={cleanupStatus} isDismissible={false}>
									{cleanupMessage}
								</Notice>
								<Spacer margin={4} />
							</>
						)}
						<Text style={{ marginBottom: "16px" }}>
							{__(
								"Clean up your database by removing unnecessary data that accumulates over time. This process will:",
								"sustainable-theme",
							)}
						</Text>
						<ul
							style={{
								marginLeft: "20px",
								marginBottom: "16px",
								lineHeight: "1.6",
							}}
						>
							<li>
								<strong>
									{__("Remove excess post revisions", "sustainable-theme")}
								</strong>{" "}
								-{" "}
								{__(
									"Keeps only the most recent versions based on your revision limit setting",
									"sustainable-theme",
								)}
							</li>
							<li>
								<strong>
									{__("Delete old auto-drafts", "sustainable-theme")}
								</strong>{" "}
								-{" "}
								{__(
									"Removes automatically saved drafts older than 7 days",
									"sustainable-theme",
								)}
							</li>
							<li>
								<strong>
									{__("Clean orphaned post metadata", "sustainable-theme")}
								</strong>{" "}
								-{" "}
								{__(
									"Removes metadata linked to deleted posts",
									"sustainable-theme",
								)}
							</li>
							<li>
								<strong>
									{__("Clean orphaned comment metadata", "sustainable-theme")}
								</strong>{" "}
								-{" "}
								{__(
									"Removes metadata linked to deleted comments",
									"sustainable-theme",
								)}
							</li>
							<li>
								<strong>
									{__("Remove expired transients", "sustainable-theme")}
								</strong>{" "}
								-{" "}
								{__("Clears expired temporary cache data", "sustainable-theme")}
							</li>
						</ul>
						<Text
							style={{ fontSize: "12px", color: "#666", marginBottom: "16px" }}
						>
							{__(
								"This cleanup runs automatically every week and shows you exactly how many items were removed.",
								"sustainable-theme",
							)}
						</Text>
						<Button
							isSecondary
							__next40pxDefaultSize
							onClick={handleDatabaseCleanup}
							isBusy={isCleaningDb}
							disabled={isCleaningDb}
							style={{ alignSelf: "start" }}
						>
							{isCleaningDb
								? __("Cleaning up...", "sustainable-theme")
								: __("Clean up database", "sustainable-theme")}
						</Button>
					</PanelBody>
				</Panel>

				<Spacer margin={12} />

				<Panel
					header={__("Image tools", "sustainable-theme")}
					className="sustainable-theme-panel"
				>
					<PanelBody
						title={__(
							"Generate blurred image placeholders",
							"sustainable-theme",
						)}
						initialOpen={false}
					>
						{blurMessage && (
							<>
								<Notice status={blurStatus} isDismissible={false}>
									{blurMessage}
								</Notice>
								<Spacer margin={4} />
							</>
						)}
						<Text style={{ marginBottom: "16px" }}>
							{__(
								"Generate blurred placeholder images for all existing media library images that don't have one yet. These are used as low-bandwidth placeholders when the grid carbon intensity is high.",
								"sustainable-theme",
							)}
						</Text>
						<Text
							style={{
								fontSize: "12px",
								color: "#666",
								marginBottom: "16px",
							}}
						>
							{__(
								"New uploads generate blur placeholders automatically. Use this button to backfill images that were uploaded before this feature was enabled.",
								"sustainable-theme",
							)}
						</Text>
						<Button
							isSecondary
							__next40pxDefaultSize
							onClick={handleGenerateBlurImages}
							isBusy={isGeneratingBlur}
							disabled={isGeneratingBlur}
							style={{ alignSelf: "start" }}
						>
							{isGeneratingBlur
								? __("Generating...", "sustainable-theme")
								: __("Generate blur placeholders", "sustainable-theme")}
						</Button>
					</PanelBody>
				</Panel>
			</PageBody>
		</PageWrapper>
	);
}
