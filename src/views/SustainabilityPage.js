import { __ } from "@wordpress/i18n";
import PageTitle from "../components/PageTitle";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";

export default function SustainabilityPage() {
	return (
		<div className="sustainable-theme-admin-page">
			<PageTitle title={__("Sustainability", "sustainable-theme")} />
			<PageHeader
				title={__("Sustainability Overview", "sustainable-theme")}
				subtitle={__(
					"Monitor and manage your website's environmental impact and sustainability metrics.",
					"sustainable-theme",
				)}
			/>

			<div style={{ padding: "20px", backgroundColor: "#f0fdf4", borderRadius: "8px", marginTop: "20px", border: "1px solid #bbf7d0" }}>
				<Text style={{ fontSize: "16px", lineHeight: "1.6", color: "#166534" }}>
					{__(
						"Sustainability metrics and environmental impact tracking will be available here. Monitor your website's carbon footprint, energy efficiency, and other green metrics to ensure your site aligns with environmental best practices.",
						"sustainable-theme",
					)}
				</Text>
				<br />
				<Text style={{ fontSize: "14px", color: "#16a34a", fontStyle: "italic" }}>
					{__("Content coming soon...", "sustainable-theme")}
				</Text>
			</div>
		</div>
	);
}
