import { __ } from "@wordpress/i18n";
import Lookbook from "./Lookbook";

const LABELS = {
	identity: "Visual Identity",
	palette_id: "Color Palette",
	font_heading: "Heading Font",
	font_body: "Body Font",
	type_scale: "Type Scale",
	heading_weight: "Heading Weight",
	heading_transform: "Heading Case",
	body_line_height: "Body Spacing",
	spacing_scale: "Section Density",
	content_width: "Content Width",
	vertical_rhythm: "Vertical Rhythm",
	hero_style: "Hero Style",
	content_layout: "Content Layout",
	border_radius: "Corners",
	shadow_style: "Shadows",
	border_style: "Borders",
	animation_style: "Animations",
	animation_trigger: "Trigger",
	animation_speed: "Speed",
};

const VALUE_LABELS = {
	"minor-third": "Minor Third (1.2×)",
	"major-third": "Major Third (1.25×)",
	"perfect-fourth": "Perfect Fourth (1.33×)",
	"augmented-fourth": "Augmented Fourth (1.41×)",
	dense: "Dense",
	compact: "Compact",
	comfortable: "Comfortable",
	spacious: "Spacious",
	editorial: "Editorial",
	"full-cover": "Full Cover",
	boxed: "Boxed",
	"split-image": "Split Image",
	"minimal-text": "Minimal Text",
	"oversized-type": "Oversized Type",
	"text-first": "Text First",
	"image-beside": "Image Beside Text",
	mixed: "Mixed Sections",
	"card-grid": "Card Grid",
	"stacked-full": "Stacked Full-Width",
	narrow: "Narrow (720px)",
	default: "Default (900px)",
	wide: "Wide (1200px)",
	"full-bleed": "Full Bleed",
	tight: "Tight",
	balanced: "Balanced",
	none: "None",
	subtle: "Subtle",
	soft: "Soft",
	rounded: "Rounded",
	pill: "Pill",
	medium: "Medium",
	dramatic: "Dramatic",
	playful: "Playful",
	glitch: "Glitch",
	strong: "Strong",
	brutalist: "Brutalist",
	light: "Light",
	bold: "Bold",
	black: "Black",
	uppercase: "UPPERCASE",
	lowercase: "lowercase",
	relaxed: "Relaxed",
	loose: "Loose",
	load: "On Page Load",
	scroll: "On Scroll",
	hover: "On Hover",
	combined: "Combined",
	slow: "Slow",
	normal: "Normal",
	fast: "Fast",
	"system-ui": "System Default",
	inter: "Inter",
	"source-serif": "Source Serif",
	"dm-sans": "DM Sans",
	playfair: "Playfair Display",
	"space-grotesk": "Space Grotesk",
	earth: "Earth & Forest",
	ocean: "Ocean Breeze",
	sunset: "Warm Sunset",
	minimal: "Minimalist",
	botanical: "Botanical Garden",
	nordic: "Nordic Frost",
	modern: "Modern & Interactive",
	editorial: "Editorial / Magazine",
	organic: "Organic / Natural",
	custom: "Custom",
};

function getLabel(value) {
	return VALUE_LABELS[value] || value;
}

export default function StepReview({ settings }) {
	const summaryKeys = Object.keys(LABELS);

	return (
		<div className="sw-review">
			<div className="sw-review__layout">
				<div className="sw-review__lookbook">
					<Lookbook settings={settings} />
				</div>
				<div className="sw-review__summary">
					<h4 className="sw-review__summary-title">
						{__("Your Style Choices", "sustainable-theme")}
					</h4>
					<div className="sw-review__list">
						{summaryKeys.map((key) => {
							const value = settings[key];
							if (!value) return null;
							if (
								key === "animation_trigger" &&
								settings.animation_style === "none"
							)
								return null;
							if (
								key === "animation_speed" &&
								settings.animation_style === "none"
							)
								return null;

							return (
								<div key={key} className="sw-review__item">
									<span className="sw-review__item-label">
										{LABELS[key]}
									</span>
									<span className="sw-review__item-value">
										{getLabel(value)}
									</span>
								</div>
							);
						})}
					</div>

					{settings.palette_id !== "custom" && (
						<div className="sw-review__palette-preview">
							<span
								style={{ backgroundColor: settings.color_primary }}
							/>
							<span
								style={{
									backgroundColor: settings.color_secondary,
								}}
							/>
							<span
								style={{ backgroundColor: settings.color_accent }}
							/>
							<span
								style={{
									backgroundColor: settings.color_background,
									border: "1px solid #e0e0e0",
								}}
							/>
							<span
								style={{ backgroundColor: settings.color_text }}
							/>
						</div>
					)}
				</div>
			</div>
		</div>
	);
}
