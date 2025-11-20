import { __ } from "@wordpress/i18n";
import { useState, Fragment } from "@wordpress/element";
import {
	Panel,
	PanelBody,
	ToggleControl,
	RangeControl,
	Modal,
	Button,
} from "@wordpress/components";
import SutainabilityModeSelector from "../components/SutainabilityModeSelector";
import Text from "../components/Text";
import Heading from "../components/Heading";
import Spacer from "../components/Spacer";
import GridIntensityPanel from "../components/GridIntensityPanel";
import { getModeDisplayName } from "../lib/settings-utils";

export default function SustainabilitySettingsPanel({
	settings,
	onSettingChange,
	onModeChange,
}) {
	const [isModalOpen, setIsModalOpen] = useState(false);

	const openModal = () => setIsModalOpen(true);
	const closeModal = () => setIsModalOpen(false);
	return (
		<Fragment>
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
						onChange={onModeChange}
					/>

{settings.sustainability_mode !== "custom" ? (
								<Text>
										{__(
											"Switch to Custom mode to modify individual settings below.",
											"sustainable-theme",
										)}
									</Text>
								) : 
								<Text>
										{__(
											"Open the Sustainability settings overview to see all the settings available.",
											"sustainable-theme",
										)}
									</Text>
							}
					<Spacer margin={2} />
									<Button
						variant="secondary"
						onClick={openModal}
						className="sustainable-theme-open-modal-button"
						__next40pxDefaultSize
					>
						{__("View Sustainability Settings Overview", "sustainable-theme")}
					</Button>
				</PanelBody>
				<GridIntensityPanel
					isEnabled={settings.use_grid_awareness}
					onToggleChange={(value) =>
						onSettingChange("use_grid_awareness", value)
					}
					apiKey={settings.electricity_maps_api_key}
					onApiKeyChange={(value) =>
						onSettingChange("electricity_maps_api_key", value)
					}
				/>
			</Panel>

			{isModalOpen && (
				<Modal
					title={__("Sustainability Settings Overview", "sustainable-theme")}
					onRequestClose={closeModal}
					className="sustainability-settings-modal"
					// isFullScreen={true}
					size="large"
				>
					<div style={{ padding: "20px 0" }}>
						{/* Display current sustainability mode */}
						<div style={{ marginBottom: "20px", padding: "12px", backgroundColor: "#f0f6fc", borderRadius: "4px", border: "1px solid #c3dafe" }}>
							<Text style={{ margin: 0 }}>
								<strong>{__("Current Sustainability Mode:", "sustainable-theme")}</strong> {getModeDisplayName(settings.sustainability_mode)}
							</Text>
							{settings.sustainability_mode !== "custom" && (
								<Text style={{ marginTop: "8px", fontSize: "13px", color: "#666" }}>
									{__("These settings are controlled by your selected mode. Switch to Custom mode to modify individual settings.", "sustainable-theme")}
								</Text>
							)}
						</div>
			
						<div
							style={{
								display: "flex",
								flexDirection: "column",
								gap: "8px",
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
								onSettingChange("disable_emojis", value)
							}
							help={__(
								"WordPress loads extra files to show emojis (😀🎉). Removing these saves energy and makes your site faster. Most people can see emojis without these files anyway.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove Video Previews - Saves bandwidth",
								"sustainable-theme",
							)}
							checked={settings.remove_embeds}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_embeds", value)
							}
							help={__(
								"When you paste a YouTube or Twitter link, WordPress tries to show a preview. This feature uses extra code and server resources. Disabling it makes your site lighter.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove Extra Website Info - Cleaner code",
								"sustainable-theme",
							)}
							checked={settings.remove_header_metadata}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_header_metadata", value)
							}
							help={__(
								"WordPress adds hidden information to every page that most visitors never see. Removing this unnecessary code reduces the size of each page.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Stop Self-Notifications - Reduces server work",
								"sustainable-theme",
							)}
							checked={settings.disable_self_pingbacks}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("disable_self_pingbacks", value)
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
								onSettingChange("remove_jquery_migrate", value)
							}
							help={__(
								"WordPress includes extra code to support very old websites. Since most people use modern browsers, removing this old code makes your site faster.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove Unnecessary Scripts - Minimal code only",
								"sustainable-theme",
							)}
							checked={settings.dequeue_non_sustainable}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("dequeue_non_sustainable", value)
							}
							help={__(
								"Removes JavaScript files that aren't essential for your website to work. This makes pages load faster and uses less energy.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove RSS Feeds - No automatic updates",
								"sustainable-theme",
							)}
							checked={settings.disable_rss_feed}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("disable_rss_feed", value)
							}
							help={__(
								"RSS feeds let people automatically get updates when you post. If you don't need this feature, removing it reduces server work and saves energy.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove API Links - Less code in pages",
								"sustainable-theme",
							)}
							checked={settings.remove_rest_output}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_rest_output", value)
							}
							help={__(
								"WordPress adds links for apps and developers in every page. If you don't use these features, removing them makes pages smaller and faster.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Block Remote Publishing - Better security",
								"sustainable-theme",
							)}
							checked={settings.disable_xmlrpc}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("disable_xmlrpc", value)
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
								onSettingChange("remove_shortlinks", value)
							}
							help={__(
								"Removes unnecessary shortlink headers and meta tags to reduce HTML overhead.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove Query Strings - Better caching",
								"sustainable-theme",
							)}
							checked={settings.remove_query_strings}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_query_strings", value)
							}
							help={__(
								"Removes version parameters from static resources for improved CDN and browser caching.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove DNS Prefetch - Fewer connections",
								"sustainable-theme",
							)}
							checked={settings.remove_dns_prefetch}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_dns_prefetch", value)
							}
							help={__(
								"Eliminates DNS prefetch hints that create unnecessary network connections and consume resources.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove WordPress Version - Security & efficiency",
								"sustainable-theme",
							)}
							checked={settings.remove_wp_version}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_wp_version", value)
							}
							help={__(
								"Hides WordPress version information from HTML output for both security and reduced processing overhead.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Enable Lazy Loading - Load images on demand",
								"sustainable-theme",
							)}
							checked={settings.enable_lazy_loading}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("enable_lazy_loading", value)
							}
							help={__(
								"Uses native browser lazy loading to only load images when they're about to enter the viewport. Saves bandwidth and improves page load speed.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
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
									onSettingChange("above_fold_image_limit", value)
								}
								min={1}
								max={5}
								help={__(
									"Number of images at the top of the page to load immediately (not lazy). Higher numbers ensure faster visible content but use more bandwidth.",
									"sustainable-theme",
								)}
								className="sustainable-theme-settings-modal-toggle-control"
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
								onSettingChange("enable_image_optimization", value)
							}
							help={__(
								"Creates optimized image sizes for different screen sizes. Reduces bandwidth usage and improves loading speed.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
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
									onSettingChange("remove_default_image_sizes", value)
								}
								help={__(
									"Removes WordPress default image sizes (medium, large, full) to save storage space and reduce processing.",
									"sustainable-theme",
								)}
								className="sustainable-theme-settings-modal-toggle-control"
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
								onSettingChange("disable_dashicons_frontend", value)
							}
							help={__(
								"Removes the Dashicons CSS file (~24KB) from frontend pages where admin icons aren't needed.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Replace Gravatar - SVG placeholders",
								"sustainable-theme",
							)}
							checked={settings.disable_gravatar}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("disable_gravatar", value)
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
								onSettingChange("disable_heartbeat", value)
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
								onSettingChange("reduce_heartbeat_frequency", value)
							}
							help={__(
								"Reduces heartbeat polling from every 15-60 seconds to every 2 minutes, significantly reducing server load.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
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
									onSettingChange("limit_post_revisions", value)
								}
								min={0}
								max={10}
								help={__(
									`Database bloat prevention by limiting post revisions to ${settings.limit_post_revisions}. Unlimited revisions can slow down your site over time.`,
									"sustainable-theme",
								)}
								className="sustainable-theme-settings-modal-toggle-control"
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
								onSettingChange(
									"limit_post_revisions",
									value ? 3 : false,
								)
							}
							help={__(
								"Enable or disable post revision limiting entirely.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
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
								onSettingChange("disable_comments", value)
							}
							help={__(
								"Completely removes the comment system, including admin pages, database queries, and frontend processing.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Remove WordPress Auto-corrections",
								"sustainable-theme",
							)}
							checked={settings.remove_capital_p_dangit}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_capital_p_dangit", value)
							}
							help={__(
								'Disables WordPress automatic text corrections (like "Wordpress" → "WordPress").',
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
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
								onSettingChange("disable_file_editing", value)
							}
							help={__(
								"Prevents file editing through WordPress admin, improving security and reducing admin overhead.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__("Remove Theme Editor", "sustainable-theme")}
							checked={settings.remove_theme_editor}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("remove_theme_editor", value)
							}
							help={__(
								"Completely removes the theme editor from the admin area.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>

						<ToggleControl
							label={__(
								"Disable Auto Updates - Manual control",
								"sustainable-theme",
							)}
							checked={settings.disable_automatic_updates}
							disabled={settings.sustainability_mode !== "custom"}
							onChange={(value) =>
								onSettingChange("disable_automatic_updates", value)
							}
							help={__(
								"Disables automatic updates to reduce background processing. Requires manual security monitoring.",
								"sustainable-theme",
							)}
							className="sustainable-theme-settings-modal-toggle-control"
						/>
						</div>
					</div>
				</Modal>
			)}
		</Fragment>
	);
}

