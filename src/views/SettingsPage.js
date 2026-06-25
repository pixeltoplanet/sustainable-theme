import { __ } from "@wordpress/i18n";
import { useEffect, useState } from "@wordpress/element";
import { Button, Notice, Panel, PanelBody, Spinner } from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";

// Set up apiFetch with proper authentication
apiFetch.use(apiFetch.createNonceMiddleware(window.wpApiSettings?.nonce || ''));
apiFetch.use(apiFetch.createRootURLMiddleware(window.wpApiSettings?.root || '/wp-json/'));
import Spacer from "../components/Spacer";
import PageWrapper from "../components/PageWrapper";
import PageBody from "../components/PageBody";
import PageTitle from "../components/PageTitle";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";

export default function SettingsPage() {
	const [recommendedPlugins, setRecommendedPlugins] = useState([]);
	const [activePlugins, setActivePlugins] = useState([]);
	const [isLoading, setIsLoading] = useState(true);
	const [installingPlugins, setInstallingPlugins] = useState(new Set());

	// Load recommended plugins on component mount
	useEffect(() => {
		const loadRecommendedPlugins = async () => {
			try {
				console.log("Loading recommended plugins...");
				console.log("wpApiSettings:", window.wpApiSettings);
				console.log("Nonce:", window.wpApiSettings?.nonce);
				
				const response = await fetch("/wp-json/sustainable-theme/v1/recommended-plugins", {
					method: "GET",
					headers: {
						"Content-Type": "application/json",
						"X-WP-Nonce": window.wpApiSettings?.nonce || "",
					},
				});

				console.log("Response status:", response.status);
				
				if (response.ok) {
					const data = await response.json();
					console.log("Plugin data:", data);
					const allPlugins = data.plugins || [];
					// Separate active and inactive plugins
					const activePluginsList = allPlugins.filter(plugin => plugin.is_active);
					const inactivePluginsList = allPlugins.filter(plugin => !plugin.is_active);
					setActivePlugins(activePluginsList);
					setRecommendedPlugins(inactivePluginsList);
				} else {
					const errorData = await response.json();
					console.error("API Error:", errorData);
				}
			} catch (error) {
				console.error("Failed to load recommended plugins:", error);
			} finally {
				setIsLoading(false);
			}
		};

		loadRecommendedPlugins();
	}, []);

	const handleInstallPlugin = async (pluginSlug) => {
		console.log("Installing plugin:", pluginSlug);
		console.log("Nonce:", window.wpApiSettings?.nonce);
		
		setInstallingPlugins(prev => new Set(prev).add(pluginSlug));

		try {
			// Try the safer AJAX method first
			const response = await fetch("/wp-json/sustainable-theme/v1/install-plugin-ajax", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": window.wpApiSettings?.nonce || "",
				},
				body: JSON.stringify({ plugin_slug: pluginSlug }),
			});

			console.log("Install response status:", response.status);
			const data = await response.json();
			console.log("Install response data:", data);

			if (data.success) {
				// Update the plugin status based on the action
				if (data.action === 'installed') {
					// Plugin was installed but not activated - update status to show "Activate" button
					setRecommendedPlugins(prev => 
						prev.map(plugin => 
							plugin.slug === pluginSlug 
								? { ...plugin, is_installed: true, is_active: false }
								: plugin
						)
					);
				} else if (data.action === 'activated' || data.action === 'installed_and_activated') {
					// Plugin was activated - move to active plugins
					setRecommendedPlugins(prev => {
						const pluginToMove = prev.find(plugin => plugin.slug === pluginSlug);
						if (pluginToMove) {
							// Remove from recommended plugins
							const updatedRecommended = prev.filter(plugin => plugin.slug !== pluginSlug);
							// Add to active plugins
							setActivePlugins(prevActive => [...prevActive, { ...pluginToMove, is_active: true }]);
							return updatedRecommended;
						}
						return prev;
					});
				}
				console.log("Plugin operation successful:", data.message);
			} else if (data.action === 'manual_install_required') {
				// Show manual installation option
				console.log("Manual install required - Full response:", data);
				console.log("Plugin name:", data.plugin_name);
				console.log("Plugin description:", data.plugin_description);
				
				const shouldInstall = confirm(
					`Automatic installation is not available for ${data.plugin_name}.\n\n` +
					`Would you like to open the WordPress plugin installation page?\n\n` +
					`Description: ${data.plugin_description || 'No description available'}`
				);
				
				if (shouldInstall) {
					window.open(data.plugin_url, '_blank');
				}
			} else if (data.action === 'filesystem_credentials_required') {
				// Show filesystem credentials option
				const shouldProvideCredentials = confirm(
					`Filesystem access is required for automatic installation.\n\n` +
					`Would you like to provide FTP/SSH credentials?\n\n` +
					`This will open the WordPress credential form.`
				);
				
				if (shouldProvideCredentials) {
					window.open(data.credentials_url, '_blank');
				}
			} else {
				console.error("Failed to install plugin:", data.message);
				// Show user-friendly error message
				alert(`Failed to install plugin: ${data.message}`);
			}
		} catch (error) {
			console.error("Failed to install plugin:", error);
			// Show user-friendly error message
			alert(`Failed to install plugin: ${error.message}`);
		} finally {
			setInstallingPlugins(prev => {
				const newSet = new Set(prev);
				newSet.delete(pluginSlug);
				return newSet;
			});
		}
	};

	const handleActivatePlugin = async (pluginSlug) => {
		console.log("Activating plugin:", pluginSlug);
		console.log("Nonce:", window.wpApiSettings?.nonce);
		
		setInstallingPlugins(prev => new Set(prev).add(pluginSlug));

		try {
			const response = await fetch("/wp-json/sustainable-theme/v1/activate-plugin", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": window.wpApiSettings?.nonce || "",
				},
				body: JSON.stringify({ plugin_slug: pluginSlug }),
			});

			console.log("Activate response status:", response.status);
			const data = await response.json();
			console.log("Activate response data:", data);

			if (data.success) {
				// Move the plugin from recommended to active plugins
				setRecommendedPlugins(prev => {
					const pluginToMove = prev.find(plugin => plugin.slug === pluginSlug);
					if (pluginToMove) {
						// Remove from recommended plugins
						const updatedRecommended = prev.filter(plugin => plugin.slug !== pluginSlug);
						// Add to active plugins
						setActivePlugins(prevActive => [...prevActive, { ...pluginToMove, is_active: true }]);
						return updatedRecommended;
					}
					return prev;
				});
				console.log("Plugin activated successfully:", data.message);
			} else {
				console.error("Failed to activate plugin:", data.message);
				// Show user-friendly error message
				alert(`Failed to activate plugin: ${data.message}`);
			}
		} catch (error) {
			console.error("Failed to activate plugin:", error);
		} finally {
			setInstallingPlugins(prev => {
				const newSet = new Set(prev);
				newSet.delete(pluginSlug);
				return newSet;
			});
		}
	};

	const getPluginStatus = (plugin) => {
		if (plugin.is_active) {
			return { text: __("Active", "sustainable-theme"), variant: "secondary", disabled: true };
		} else if (plugin.is_installed) {
			return { text: __("Activate", "sustainable-theme"), variant: "primary", disabled: false };
		} else {
			return { text: __("Install", "sustainable-theme"), variant: "primary", disabled: false };
		}
	};

	const handlePluginAction = (plugin) => {
		if (plugin.is_active) {
			// Plugin is already active, no action needed
			return;
		} else if (plugin.is_installed) {
			// Plugin is installed but not active, activate it
			handleActivatePlugin(plugin.slug);
		} else {
			// Plugin is not installed, install it
			handleInstallPlugin(plugin.slug);
		}
	};
	
	return (
		<PageWrapper>
			<PageHeader>
				<PageTitle>
					{__("The Sustainable Theme", "sustainable-theme")}
				</PageTitle>
				<Text>
					{__(
						"The Sustainable Theme allows you to create a sustainable website with the smallest possible carbon footprint.",
						"sustainable-theme",
					)}
				</Text>
			</PageHeader>

			<PageBody>
				<Notice
					status="info"
					isDismissible={false}
					style={{ marginTop: "20px" }}
				>
					{__("We recommend installing the following plugins to get the most out of the Sustainable Theme:", "sustainable-theme")}
				</Notice>

				<Spacer margin={4} />

				{activePlugins.length > 0 && (
					<>
						<Panel header={__("Active Plugins", "sustainable-theme")}>
							<PanelBody>
								<div style={{ display: "flex", flexDirection: "column", gap: "16px" }}>
									{activePlugins.map((plugin) => (
										<div
											key={plugin.slug}
											style={{
												display: "flex",
												justifyContent: "space-between",
												alignItems: "center",
												padding: "16px",
												border: "1px solid #28a745",
												borderRadius: "4px",
												backgroundColor: "#f0f8f0",
											}}
										>
											<div style={{ flex: 1 }}>
												<h4 style={{ margin: "0 0 8px 0", fontSize: "16px" }}>
													{plugin.name}
												</h4>
												<p style={{ margin: "0", color: "#666", fontSize: "14px" }}>
													{plugin.description}
												</p>
												<Text style={{ fontSize: "12px", color: "#28a745", marginTop: "4px" }}>
													✓ {__("Plugin is active and working", "sustainable-theme")}
												</Text>
											</div>
											<div style={{ marginLeft: "16px" }}>
												<Button
													variant="secondary"
													disabled={true}
													__next40pxDefaultSize
												>
													{__("Active", "sustainable-theme")}
												</Button>
											</div>
										</div>
									))}
								</div>
							</PanelBody>
						</Panel>
						<Spacer margin={4} />
					</>
				)}

				<Panel header={__("Recommended Plugins", "sustainable-theme")}>
					<PanelBody>
						{isLoading ? (
							<div style={{ display: "flex", justifyContent: "center", padding: "20px" }}>
								<Spinner />
							</div>
						) : (
							<div style={{ display: "flex", flexDirection: "column", gap: "16px" }}>
								{recommendedPlugins.map((plugin) => {
									const status = getPluginStatus(plugin);
									const isInstalling = installingPlugins.has(plugin.slug);
									
									return (
										<div
											key={plugin.slug}
											style={{
												display: "flex",
												justifyContent: "space-between",
												alignItems: "center",
												padding: "16px",
												border: "1px solid #ddd",
												borderRadius: "4px",
												backgroundColor: plugin.is_active ? "#f0f8f0" : "#fff",
											}}
										>
											<div style={{ flex: 1 }}>
												<h4 style={{ margin: "0 0 8px 0", fontSize: "16px" }}>
													{plugin.name}
												</h4>
												<p style={{ margin: "0", color: "#666", fontSize: "14px" }}>
													{plugin.description}
												</p>
												{plugin.is_active && (
													<Text style={{ fontSize: "12px", color: "#28a745", marginTop: "4px" }}>
														✓ {__("Plugin is active and working", "sustainable-theme")}
													</Text>
												)}
											</div>
											<div style={{ marginLeft: "16px" }}>
											<Button
												variant={status.variant}
												disabled={status.disabled || isInstalling}
												onClick={() => handlePluginAction(plugin)}
												__next40pxDefaultSize
											>
												{isInstalling ? (
													<>
														<Spinner style={{ marginRight: "8px" }} />
														{__("Processing...", "sustainable-theme")}
													</>
												) : (
													status.text
												)}
												</Button>
											</div>
										</div>
									);
								})}
							</div>
						)}
					</PanelBody>
				</Panel>

				<Spacer margin={8} />

				<Panel header={__("Quick Actions", "sustainable-theme")}>
					<PanelBody title={__("Navigation", "sustainable-theme")}>
						<Text style={{ marginBottom: "16px" }}>
							{__("Access different sections of the theme:", "sustainable-theme")}
						</Text>
						<div style={{ display: "flex", gap: "12px", flexWrap: "wrap" }}>
							<Button
								variant="secondary"
								onClick={() => window.location.href = "/wp-admin/admin.php?page=sustainable-theme-sustainability"}
							>
								{__("Sustainability Settings", "sustainable-theme")}
							</Button>
							<Button
								variant="secondary"
								onClick={() => window.location.href = "/wp-admin/admin.php?page=sustainable-theme-design"}
							>
								{__("Design Settings", "sustainable-theme")}
							</Button>
						</div>
					</PanelBody>
				</Panel>
			</PageBody>
		</PageWrapper>
	);
}
