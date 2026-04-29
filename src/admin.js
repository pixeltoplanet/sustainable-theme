import { createRoot } from "@wordpress/element";
import AdminPage from "./views/AdminPage";
import "./styles/admin.scss";

document.addEventListener("DOMContentLoaded", () => {
	const adminRoot = document.getElementById("sustainable-theme-page-root");
	if (adminRoot) {
		const root = createRoot(adminRoot);
		root.render(<AdminPage />);
	}
});
