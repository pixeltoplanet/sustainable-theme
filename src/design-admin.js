import { createRoot } from "@wordpress/element";
import DesignPage from "./views/DesignPage";
import "./styles/admin.scss";

document.addEventListener("DOMContentLoaded", () => {
	const pageRoot = document.getElementById("sustainable-theme-design-page-root");
	if (pageRoot) {
		const root = createRoot(pageRoot);
		root.render(<DesignPage />);
	}
});
