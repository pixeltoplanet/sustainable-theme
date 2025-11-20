import { __ } from "@wordpress/i18n";
import {
	Panel,
	PanelBody,
	Button,
	Notice,
} from "@wordpress/components";
import Text from "./Text";
import Spacer from "./Spacer";

export default function DatabaseCleanupPanel({
	onCleanup,
	isCleaningDb,
	cleanupMessage,
	cleanupStatus,
}) {
	return (
		<Panel
			header={__("Database cleanup", "sustainable-theme")}
			className="sustainable-theme-panel"
		>
			<PanelBody
				title={__("Remove old data", "sustainable-theme")}
				initialOpen={false}
			>
				{cleanupMessage && (
					<>
						<Notice status={cleanupStatus} isDismissible={false}>
							{cleanupMessage}
						</Notice>
						<Spacer margin={4} />
					</>
				)}
				<Text style={{ marginBottom: "16px" }}>
					{__(
						"Clean up your database by removing unnecessary data that accumulates over time. This process will:",
						"sustainable-theme",
					)}
				</Text>
				<ul
					style={{
						marginLeft: "20px",
						marginBottom: "16px",
						lineHeight: "1.6",
					}}
				>
					<li>
						<strong>
							{__("Remove excess post revisions", "sustainable-theme")}
						</strong>{" "}
						-{" "}
						{__(
							"Keeps only the most recent versions based on your revision limit setting",
							"sustainable-theme",
						)}
					</li>
					<li>
						<strong>
							{__("Delete old auto-drafts", "sustainable-theme")}
						</strong>{" "}
						-{" "}
						{__(
							"Removes automatically saved drafts older than 7 days",
							"sustainable-theme",
						)}
					</li>
					<li>
						<strong>
							{__("Clean orphaned post metadata", "sustainable-theme")}
						</strong>{" "}
						-{" "}
						{__(
							"Removes metadata linked to deleted posts",
							"sustainable-theme",
						)}
					</li>
					<li>
						<strong>
							{__("Clean orphaned comment metadata", "sustainable-theme")}
						</strong>{" "}
						-{" "}
						{__(
							"Removes metadata linked to deleted comments",
							"sustainable-theme",
						)}
					</li>
					<li>
						<strong>
							{__("Remove expired transients", "sustainable-theme")}
						</strong>{" "}
						-{" "}
						{__("Clears expired temporary cache data", "sustainable-theme")}
					</li>
				</ul>
				<Text
					style={{ fontSize: "12px", color: "#666", marginBottom: "16px" }}
				>
					{__(
						"This cleanup runs automatically every week and shows you exactly how many items were removed.",
						"sustainable-theme",
					)}
				</Text>
				<Button
					isSecondary
					__next40pxDefaultSize
					onClick={onCleanup}
					isBusy={isCleaningDb}
					disabled={isCleaningDb}
					style={{ alignSelf: "start" }}
				>
					{isCleaningDb
						? __("Cleaning up...", "sustainable-theme")
						: __("Clean up database", "sustainable-theme")}
				</Button>
			</PanelBody>
		</Panel>
	);
}
