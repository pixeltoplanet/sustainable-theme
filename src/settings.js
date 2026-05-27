import { createRoot } from "@wordpress/element";
import SettingsPage from "./views/SettingsPage.js";
import "./styles/admin.scss";

document.addEventListener("DOMContentLoaded", () => {
	const pageRoot = document.getElementById("sustainable-theme-settings-page-root");
	if (pageRoot) {
		const root = createRoot(pageRoot);
		root.render(<SettingsPage />);
	}
});
