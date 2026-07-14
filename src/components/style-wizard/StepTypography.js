import { __ } from "@wordpress/i18n";

const FONT_OPTIONS = [
	{
		id: "system-ui",
		label: "System Default",
		description: "Fast loading, native feel",
		stack: "system-ui, -apple-system, sans-serif",
	},
	{
		id: "inter",
		label: "Inter",
		description: "Modern geometric sans-serif",
		stack: "'Inter', system-ui, sans-serif",
	},
	{
		id: "source-serif",
		label: "Source Serif",
		description: "Elegant serif, excellent readability",
		stack: "'Source Serif 4', Georgia, serif",
	},
	{
		id: "dm-sans",
		label: "DM Sans",
		description: "Friendly, soft rounded forms",
		stack: "'DM Sans', system-ui, sans-serif",
	},
	{
		id: "playfair",
		label: "Playfair Display",
		description: "High contrast editorial serif",
		stack: "'Playfair Display', Georgia, serif",
	},
	{
		id: "space-grotesk",
		label: "Space Grotesk",
		description: "Bold, futuristic proportional",
		stack: "'Space Grotesk', system-ui, sans-serif",
	},
];

const SCALE_OPTIONS = [
	{
		id: "minor-third",
		label: "Minor Third (1.2×)",
		description: "Subtle, compact",
	},
	{
		id: "major-third",
		label: "Major Third (1.25×)",
		description: "Balanced, versatile",
	},
	{
		id: "perfect-fourth",
		label: "Perfect Fourth (1.33×)",
		description: "Strong, editorial",
	},
	{
		id: "augmented-fourth",
		label: "Augmented Fourth (1.41×)",
		description: "Dramatic, statement",
	},
];

const WEIGHT_OPTIONS = [
	{ id: "light", label: "Light", preview: "300" },
	{ id: "normal", label: "Regular", preview: "400" },
	{ id: "bold", label: "Bold", preview: "700" },
	{ id: "black", label: "Black", preview: "900" },
];

const TRANSFORM_OPTIONS = [
	{ id: "none", label: "Normal", example: "Hello World" },
	{ id: "uppercase", label: "UPPERCASE", example: "HELLO WORLD" },
	{ id: "lowercase", label: "lowercase", example: "hello world" },
];

const SPACING_OPTIONS = [
	{ id: "tight", label: "Tight", value: "-0.03em" },
	{ id: "normal", label: "Normal", value: "0" },
	{ id: "wide", label: "Wide", value: "0.05em" },
	{ id: "extra-wide", label: "Extra Wide", value: "0.12em" },
];

const LINE_HEIGHT_OPTIONS = [
	{ id: "tight", label: "Tight", value: "1.2", desc: "Dense, impactful" },
	{ id: "normal", label: "Normal", value: "1.5", desc: "Standard readability" },
	{ id: "relaxed", label: "Relaxed", value: "1.7", desc: "Airy, easy scanning" },
	{ id: "loose", label: "Loose", value: "2.0", desc: "Very open, luxurious" },
];

export default function StepTypography({ settings, onChange }) {
	return (
		<div className="sw-typography">
			{/* Font pairing */}
			<div className="sw-typography__section">
				<h4 className="sw-typography__section-title">
					{__("Heading Font", "sustainable-theme")}
				</h4>
				<div className="sw-typography__font-grid">
					{FONT_OPTIONS.map((font) => (
						<button
							key={font.id}
							type="button"
							className={`sw-typography__font-card ${settings.font_heading === font.id ? "sw-typography__font-card--selected" : ""}`}
							onClick={() =>
								onChange({ font_heading: font.id })
							}
						>
							<span
								className="sw-typography__font-preview"
								style={{ fontFamily: font.stack }}
							>
								Aa
							</span>
							<span className="sw-typography__font-name">
								{font.label}
							</span>
							<span className="sw-typography__font-desc">
								{font.description}
							</span>
						</button>
					))}
				</div>
			</div>

			<div className="sw-typography__section">
				<h4 className="sw-typography__section-title">
					{__("Body Font", "sustainable-theme")}
				</h4>
				<div className="sw-typography__font-grid">
					{FONT_OPTIONS.map((font) => (
						<button
							key={font.id}
							type="button"
							className={`sw-typography__font-card ${settings.font_body === font.id ? "sw-typography__font-card--selected" : ""}`}
							onClick={() => onChange({ font_body: font.id })}
						>
							<span
								className="sw-typography__font-preview sw-typography__font-preview--body"
								style={{ fontFamily: font.stack }}
							>
								The quick brown fox jumps.
							</span>
							<span className="sw-typography__font-name">
								{font.label}
							</span>
						</button>
					))}
				</div>
			</div>

			{/* Heading character */}
			<div className="sw-typography__section">
				<h4 className="sw-typography__section-title">
					{__("Heading Character", "sustainable-theme")}
				</h4>
				<p className="sw-typography__section-desc">
					{__(
						"Weight, casing, and spacing define how headings feel — from whisper-light to brutally heavy.",
						"sustainable-theme",
					)}
				</p>

				<div className="sw-typography__row">
					<div className="sw-typography__row-group">
						<label className="sw-typography__mini-label">
							{__("Weight", "sustainable-theme")}
						</label>
						<div className="sw-typography__pill-row">
							{WEIGHT_OPTIONS.map((opt) => (
								<button
									key={opt.id}
									type="button"
									className={`sw-typography__pill ${settings.heading_weight === opt.id ? "sw-typography__pill--selected" : ""}`}
									onClick={() =>
										onChange({ heading_weight: opt.id })
									}
								>
									<span
										style={{ fontWeight: opt.preview }}
									>
										{opt.label}
									</span>
								</button>
							))}
						</div>
					</div>

					<div className="sw-typography__row-group">
						<label className="sw-typography__mini-label">
							{__("Transform", "sustainable-theme")}
						</label>
						<div className="sw-typography__pill-row">
							{TRANSFORM_OPTIONS.map((opt) => (
								<button
									key={opt.id}
									type="button"
									className={`sw-typography__pill ${settings.heading_transform === opt.id ? "sw-typography__pill--selected" : ""}`}
									onClick={() =>
										onChange({
											heading_transform: opt.id,
										})
									}
								>
									{opt.example}
								</button>
							))}
						</div>
					</div>

					<div className="sw-typography__row-group">
						<label className="sw-typography__mini-label">
							{__("Letter Spacing", "sustainable-theme")}
						</label>
						<div className="sw-typography__pill-row">
							{SPACING_OPTIONS.map((opt) => (
								<button
									key={opt.id}
									type="button"
									className={`sw-typography__pill ${settings.heading_letter_spacing === opt.id ? "sw-typography__pill--selected" : ""}`}
									onClick={() =>
										onChange({
											heading_letter_spacing: opt.id,
										})
									}
								>
									{opt.label}
								</button>
							))}
						</div>
					</div>
				</div>

				{/* Live heading preview */}
				<div className="sw-typography__heading-preview">
					<span
						style={{
							fontWeight:
								WEIGHT_OPTIONS.find(
									(w) => w.id === settings.heading_weight,
								)?.preview || "700",
							textTransform:
								settings.heading_transform === "none"
									? "none"
									: settings.heading_transform,
							letterSpacing:
								SPACING_OPTIONS.find(
									(s) =>
										s.id ===
										settings.heading_letter_spacing,
								)?.value || "0",
							fontFamily:
								FONT_OPTIONS.find(
									(f) => f.id === settings.font_heading,
								)?.stack || "system-ui",
						}}
					>
						{settings.heading_transform === "uppercase"
							? "YOUR HEADING STYLE"
							: settings.heading_transform === "lowercase"
								? "your heading style"
								: "Your Heading Style"}
					</span>
				</div>
			</div>

			{/* Scale & rhythm */}
			<div className="sw-typography__section">
				<h4 className="sw-typography__section-title">
					{__("Scale & Reading Rhythm", "sustainable-theme")}
				</h4>

				<div className="sw-typography__row">
					<div className="sw-typography__row-group">
						<label className="sw-typography__mini-label">
							{__("Type Scale", "sustainable-theme")}
						</label>
						<div className="sw-typography__scale-grid">
							{SCALE_OPTIONS.map((scale) => (
								<button
									key={scale.id}
									type="button"
									className={`sw-typography__scale-card ${settings.type_scale === scale.id ? "sw-typography__scale-card--selected" : ""}`}
									onClick={() =>
										onChange({ type_scale: scale.id })
									}
								>
									<span className="sw-typography__scale-name">
										{scale.label}
									</span>
									<span className="sw-typography__scale-desc">
										{scale.description}
									</span>
								</button>
							))}
						</div>
					</div>

					<div className="sw-typography__row-group">
						<label className="sw-typography__mini-label">
							{__("Body Line Height", "sustainable-theme")}
						</label>
						<div className="sw-typography__pill-row">
							{LINE_HEIGHT_OPTIONS.map((opt) => (
								<button
									key={opt.id}
									type="button"
									className={`sw-typography__pill ${settings.body_line_height === opt.id ? "sw-typography__pill--selected" : ""}`}
									onClick={() =>
										onChange({
											body_line_height: opt.id,
										})
									}
									title={opt.desc}
								>
									{opt.label}
								</button>
							))}
						</div>
					</div>
				</div>
			</div>
		</div>
	);
}
