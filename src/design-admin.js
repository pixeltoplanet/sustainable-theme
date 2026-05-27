import { createRoot } from "@wordpress/element";
import DesignPage from "./views/DesignPage";

// Initialize the design page
const designPageRoot = document.getElementById("sustainable-theme-design-page-root");
if (designPageRoot) {
	const root = createRoot(designPageRoot);
	root.render(<DesignPage />);
}
