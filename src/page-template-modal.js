import { registerPlugin } from "@wordpress/plugins";
import PageTemplateModal from "./components/PageTemplateModal";
import "./styles/page-template-modal.scss";

registerPlugin("sustainable-page-template-modal", {
	render: PageTemplateModal,
});
