import { createRoot } from "@wordpress/element";
import StyleWizardPage from "./views/StyleWizardPage";
import "./styles/admin.scss";
import "./styles/style-wizard.scss";

document.addEventListener("DOMContentLoaded", () => {
	const pageRoot = document.getElementById(
		"sustainable-theme-style-wizard-root",
	);
	if (pageRoot) {
		const root = createRoot(pageRoot);
		root.render(<StyleWizardPage />);
	}
});
