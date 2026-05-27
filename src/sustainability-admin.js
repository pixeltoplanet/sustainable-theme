import { createRoot } from "@wordpress/element";
import SustainabilityPage from "./views/SustainabilityPage";

// Initialize the sustainability page
const sustainabilityPageRoot = document.getElementById("sustainable-theme-sustainability-page-root");
if (sustainabilityPageRoot) {
	const root = createRoot(sustainabilityPageRoot);
	root.render(<SustainabilityPage />);
}
