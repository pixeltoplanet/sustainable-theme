import { __ } from "@wordpress/i18n";
import PageTitle from "../components/PageTitle";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";

export default function DesignPage() {
	return (
		<div className="sustainable-theme-admin-page">
			<PageTitle title={__("Design", "sustainable-theme")} />
			<PageHeader
				title={__("Design Settings", "sustainable-theme")}
				subtitle={__(
					"Customize the visual appearance and design elements of your sustainable theme.",
					"sustainable-theme",
				)}
			/>

			<div style={{ padding: "20px", backgroundColor: "#f9fafb", borderRadius: "8px", marginTop: "20px" }}>
				<Text style={{ fontSize: "16px", lineHeight: "1.6", color: "#374151" }}>
					{__(
						"Design customization options will be available here. You can configure colors, typography, layouts, and other visual elements to match your brand and sustainability goals.",
						"sustainable-theme",
					)}
				</Text>
				<br />
				<Text style={{ fontSize: "14px", color: "#6b7280", fontStyle: "italic" }}>
					{__("Content coming soon...", "sustainable-theme")}
				</Text>
			</div>
		</div>
	);
}
