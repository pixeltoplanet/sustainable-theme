import { __ } from "@wordpress/i18n";
import { useEffect, useState, useCallback } from "@wordpress/element";
import { Button, Notice, Panel, PanelBody, Spinner, SnackbarList } from "@wordpress/components";
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

const STATUS_STYLES = {
	active: {
		border: "1px solid #28a745",
		backgroundColor: "#f0f8f0",
		borderLeft: "4px solid #28a745",
	},
	installed: {
		border: "1px solid #e6a817",
		backgroundColor: "#fefcf3",
		borderLeft: "4px solid #e6a817",
	},
	notInstalled: {
		border: "1px solid #ddd",
		backgroundColor: "#fff",
		borderLeft: "4px solid #ddd",
	},
};

export default function SettingsPage() {
	const [recommendedPlugins, setRecommendedPlugins] = useState([]);
	const [activePlugins, setActivePlugins] = useState([]);
	const [isLoading, setIsLoading] = useState(true);
	const [installingPlugins, setInstallingPlugins] = useState(new Set());
	const [pluginActions, setPluginActions] = useState({});
	const [notices, setNotices] = useState([]);
	const [pluginErrors, setPluginErrors] = useState({});

	const addNotice = useCallback((message, type = "success") => {
		const id = `notice-${Date.now()}`;
		setNotices(prev => [...prev, { id, content: message, type }]);
		setTimeout(() => {
			setNotices(prev => prev.filter(n => n.id !== id));
		}, 4000);
	}, []);

	const setPluginError = useCallback((slug, message) => {
		setPluginErrors(prev => ({ ...prev, [slug]: message }));
		setTimeout(() => {
			setPluginErrors(prev => {
				const next = { ...prev };
				delete next[slug];
				return next;
			});
		}, 5000);
	}, []);

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
		setInstallingPlugins(prev => new Set(prev).add(pluginSlug));
		setPluginActions(prev => ({ ...prev, [pluginSlug]: "installing" }));

		try {
			const response = await fetch("/wp-json/sustainable-theme/v1/install-plugin-ajax", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": window.wpApiSettings?.nonce || "",
				},
				body: JSON.stringify({ plugin_slug: pluginSlug }),
			});

			const data = await response.json();

			if (data.success) {
				if (data.action === 'installed') {
					setRecommendedPlugins(prev => 
						prev.map(plugin => 
							plugin.slug === pluginSlug 
								? { ...plugin, is_installed: true, is_active: false }
								: plugin
						)
					);
					const pluginName = recommendedPlugins.find(p => p.slug === pluginSlug)?.name || pluginSlug;
					addNotice(__(`${pluginName} installed successfully. Click "Activate" to enable it.`, "sustainable-theme"));
				} else if (data.action === 'activated' || data.action === 'installed_and_activated') {
					setRecommendedPlugins(prev => {
						const pluginToMove = prev.find(plugin => plugin.slug === pluginSlug);
						if (pluginToMove) {
							const updatedRecommended = prev.filter(plugin => plugin.slug !== pluginSlug);
							setActivePlugins(prevActive => [...prevActive, { ...pluginToMove, is_active: true }]);
							addNotice(__(`${pluginToMove.name} is now active!`, "sustainable-theme"));
							return updatedRecommended;
						}
						return prev;
					});
				}
			} else if (data.action === 'manual_install_required') {
				const shouldInstall = confirm(
					`Automatic installation is not available for ${data.plugin_name}.\n\n` +
					`Would you like to open the WordPress plugin installation page?\n\n` +
					`Description: ${data.plugin_description || 'No description available'}`
				);
				
				if (shouldInstall) {
					window.open(data.plugin_url, '_blank');
				}
			} else if (data.action === 'filesystem_credentials_required') {
				const shouldProvideCredentials = confirm(
					`Filesystem access is required for automatic installation.\n\n` +
					`Would you like to provide FTP/SSH credentials?\n\n` +
					`This will open the WordPress credential form.`
				);
				
				if (shouldProvideCredentials) {
					window.open(data.credentials_url, '_blank');
				}
			} else {
				setPluginError(pluginSlug, data.message || __("Installation failed", "sustainable-theme"));
			}
		} catch (error) {
			setPluginError(pluginSlug, error.message || __("Network error during installation", "sustainable-theme"));
		} finally {
			setInstallingPlugins(prev => {
				const newSet = new Set(prev);
				newSet.delete(pluginSlug);
				return newSet;
			});
			setPluginActions(prev => {
				const next = { ...prev };
				delete next[pluginSlug];
				return next;
			});
		}
	};

	const handleActivatePlugin = async (pluginSlug) => {
		setInstallingPlugins(prev => new Set(prev).add(pluginSlug));
		setPluginActions(prev => ({ ...prev, [pluginSlug]: "activating" }));

		try {
			const response = await fetch("/wp-json/sustainable-theme/v1/activate-plugin", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": window.wpApiSettings?.nonce || "",
				},
				body: JSON.stringify({ plugin_slug: pluginSlug }),
			});

			const data = await response.json();

			if (data.success) {
				setRecommendedPlugins(prev => {
					const pluginToMove = prev.find(plugin => plugin.slug === pluginSlug);
					if (pluginToMove) {
						const updatedRecommended = prev.filter(plugin => plugin.slug !== pluginSlug);
						setActivePlugins(prevActive => [...prevActive, { ...pluginToMove, is_active: true }]);
						addNotice(__(`${pluginToMove.name} activated successfully!`, "sustainable-theme"));
						return updatedRecommended;
					}
					return prev;
				});
			} else {
				setPluginError(pluginSlug, data.message || __("Activation failed", "sustainable-theme"));
			}
		} catch (error) {
			setPluginError(pluginSlug, error.message || __("Network error during activation", "sustainable-theme"));
		} finally {
			setInstallingPlugins(prev => {
				const newSet = new Set(prev);
				newSet.delete(pluginSlug);
				return newSet;
			});
			setPluginActions(prev => {
				const next = { ...prev };
				delete next[pluginSlug];
				return next;
			});
		}
	};

	const getPluginStatus = (plugin) => {
		if (plugin.is_active) {
			return {
				text: __("Active", "sustainable-theme"),
				variant: "secondary",
				disabled: true,
				badge: __("Active", "sustainable-theme"),
				badgeColor: "#28a745",
				style: STATUS_STYLES.active,
			};
		} else if (plugin.is_installed) {
			return {
				text: __("Activate", "sustainable-theme"),
				variant: "primary",
				disabled: false,
				badge: __("Installed — not activated", "sustainable-theme"),
				badgeColor: "#b45309",
				style: STATUS_STYLES.installed,
			};
		} else {
			return {
				text: __("Install", "sustainable-theme"),
				variant: "primary",
				disabled: false,
				badge: __("Not installed", "sustainable-theme"),
				badgeColor: "#6b7280",
				style: STATUS_STYLES.notInstalled,
			};
		}
	};

	const getSpinnerText = (pluginSlug) => {
		const action = pluginActions[pluginSlug];
		if (action === "installing") return __("Installing…", "sustainable-theme");
		if (action === "activating") return __("Activating…", "sustainable-theme");
		return __("Processing…", "sustainable-theme");
	};

	const handlePluginAction = (plugin) => {
		if (plugin.is_active) {
			return;
		} else if (plugin.is_installed) {
			handleActivatePlugin(plugin.slug);
		} else {
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
												borderRadius: "4px",
												...STATUS_STYLES.active,
											}}
										>
											<div style={{ flex: 1 }}>
												<div style={{ display: "flex", alignItems: "center", gap: "10px", marginBottom: "8px" }}>
													<h4 style={{ margin: 0, fontSize: "16px" }}>
														{plugin.name}
													</h4>
													<span
														style={{
															fontSize: "11px",
															fontWeight: 500,
															color: "#28a745",
															backgroundColor: "#28a74514",
															border: "1px solid #28a74533",
															padding: "2px 8px",
															borderRadius: "12px",
															whiteSpace: "nowrap",
														}}
													>
														✓ {__("Active", "sustainable-theme")}
													</span>
												</div>
												<p style={{ margin: "0", color: "#666", fontSize: "14px" }}>
													{plugin.description}
												</p>
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
						) : recommendedPlugins.length === 0 ? (
							<Text style={{ color: "#666", fontStyle: "italic" }}>
								{__("All recommended plugins are active!", "sustainable-theme")}
							</Text>
						) : (
							<div style={{ display: "flex", flexDirection: "column", gap: "16px" }}>
								{recommendedPlugins.map((plugin) => {
									const status = getPluginStatus(plugin);
									const isInstalling = installingPlugins.has(plugin.slug);
									const error = pluginErrors[plugin.slug];
									
									return (
										<div
											key={plugin.slug}
											style={{
												display: "flex",
												justifyContent: "space-between",
												alignItems: "center",
												padding: "16px",
												borderRadius: "4px",
												...status.style,
											}}
										>
											<div style={{ flex: 1 }}>
												<div style={{ display: "flex", alignItems: "center", gap: "10px", marginBottom: "8px" }}>
													<h4 style={{ margin: 0, fontSize: "16px" }}>
														{plugin.name}
													</h4>
													<span
														style={{
															fontSize: "11px",
															fontWeight: 500,
															color: status.badgeColor,
															backgroundColor: `${status.badgeColor}14`,
															border: `1px solid ${status.badgeColor}33`,
															padding: "2px 8px",
															borderRadius: "12px",
															whiteSpace: "nowrap",
														}}
													>
														{status.badge}
													</span>
												</div>
												<p style={{ margin: "0", color: "#666", fontSize: "14px" }}>
													{plugin.description}
												</p>
												{error && (
													<Text style={{ fontSize: "12px", color: "#dc2626", marginTop: "8px" }}>
														⚠ {error}
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
															{getSpinnerText(plugin.slug)}
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

				{notices.length > 0 && (
					<div
						style={{
							position: "fixed",
							bottom: "70px",
							right: "40px",
							zIndex: 100000,
							minWidth: "400px",
							maxWidth: "540px",
							fontSize: "14px",
						}}
					>
						<SnackbarList
							notices={notices.map(n => ({
								id: n.id,
								content: n.content,
								status: n.type,
							}))}
							onRemove={(id) => setNotices(prev => prev.filter(n => n.id !== id))}
						/>
					</div>
				)}
			</PageBody>
		</PageWrapper>
	);
}
