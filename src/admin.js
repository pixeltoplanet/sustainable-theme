import { createRoot } from "@wordpress/element";
import AdminPage from "./views/AdminPage";
import "./styles/admin.scss";
import "./lib/grid-awareness.ts";

// Set up grid awareness settings for admin
window.sustainableThemeGridSettings = {
	enabled: true, // Always enable in admin for testing
	apiUrl: "/wp-json/sustainable-theme/v1/grid-status",
	nonce: "", // Will be set by PHP
};

document.addEventListener("DOMContentLoaded", () => {
	const adminRoot = document.getElementById("sustainable-theme-page-root");
	if (adminRoot) {
		const root = createRoot(adminRoot);
		root.render(<AdminPage />);
	}
});
