import { __ } from "@wordpress/i18n";

const RADIUS_OPTIONS = [
	{
		id: "none",
		label: "Sharp",
		description: "No rounding — modern, editorial",
		value: "0",
	},
	{
		id: "subtle",
		label: "Subtle",
		description: "Barely rounded — clean, professional",
		value: "4px",
	},
	{
		id: "soft",
		label: "Soft",
		description: "Gently rounded — friendly, approachable",
		value: "12px",
	},
	{
		id: "rounded",
		label: "Rounded",
		description: "Noticeably rounded — playful, contemporary",
		value: "20px",
	},
	{
		id: "pill",
		label: "Pill",
		description: "Fully rounded — bold, statement-making",
		value: "9999px",
	},
];

const SHADOW_OPTIONS = [
	{
		id: "none",
		label: "Flat",
		description: "No shadows — minimal, clean",
		css: "none",
	},
	{
		id: "subtle",
		label: "Subtle",
		description: "Gentle lift — adds depth without distraction",
		css: "0 1px 3px rgba(0,0,0,.08)",
	},
	{
		id: "medium",
		label: "Medium",
		description: "Clear elevation — cards and surfaces feel layered",
		css: "0 4px 12px rgba(0,0,0,.1)",
	},
	{
		id: "dramatic",
		label: "Dramatic",
		description: "Strong depth — bold, striking presence",
		css: "0 8px 30px rgba(0,0,0,.15)",
	},
];

const BORDER_OPTIONS = [
	{
		id: "none",
		label: "None",
		description: "No visible borders — clean surfaces",
	},
	{
		id: "subtle",
		label: "Subtle",
		description: "Light divider lines — structured, tidy",
	},
	{
		id: "strong",
		label: "Strong",
		description: "Visible borders on cards and images — defined, graphic",
	},
	{
		id: "brutalist",
		label: "Brutalist",
		description: "Thick black borders on everything — raw, uncompromising",
	},
];

export default function StepShape({ settings, onChange }) {
	return (
		<div className="sw-shape">
			<div className="sw-shape__section">
				<h4 className="sw-shape__section-title">
					{__("Corner Style", "sustainable-theme")}
				</h4>
				<p className="sw-shape__section-desc">
					{__(
						"How round should corners be on cards, buttons and images?",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-shape__grid">
					{RADIUS_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-shape__card ${settings.border_radius === option.id ? "sw-shape__card--selected" : ""}`}
							onClick={() =>
								onChange({ border_radius: option.id })
							}
						>
							<div className="sw-shape__preview">
								<div
									className="sw-shape__box"
									style={{
										borderRadius:
											option.id === "pill"
												? "20px"
												: option.value,
									}}
								/>
								<div
									className="sw-shape__button-preview"
									style={{ borderRadius: option.value }}
								/>
							</div>
							<span className="sw-shape__label">
								{option.label}
							</span>
							<span className="sw-shape__desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>

			<div className="sw-shape__section">
				<h4 className="sw-shape__section-title">
					{__("Shadow Depth", "sustainable-theme")}
				</h4>
				<p className="sw-shape__section-desc">
					{__(
						"How much depth should surfaces and cards have?",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-shape__grid sw-shape__grid--wide">
					{SHADOW_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-shape__card ${settings.shadow_style === option.id ? "sw-shape__card--selected" : ""}`}
							onClick={() =>
								onChange({ shadow_style: option.id })
							}
						>
							<div className="sw-shape__preview">
								<div
									className="sw-shape__shadow-box"
									style={{ boxShadow: option.css }}
								/>
							</div>
							<span className="sw-shape__label">
								{option.label}
							</span>
							<span className="sw-shape__desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>

			<div className="sw-shape__section">
				<h4 className="sw-shape__section-title">
					{__("Border Treatment", "sustainable-theme")}
				</h4>
				<p className="sw-shape__section-desc">
					{__(
						"Borders add definition and structure. Brutalist borders make a loud statement.",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-shape__grid sw-shape__grid--wide">
					{BORDER_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-shape__card ${settings.border_style === option.id ? "sw-shape__card--selected" : ""}`}
							onClick={() =>
								onChange({ border_style: option.id })
							}
						>
							<div className="sw-shape__preview">
								<div
									className="sw-shape__border-box"
									data-border={option.id}
								/>
							</div>
							<span className="sw-shape__label">
								{option.label}
							</span>
							<span className="sw-shape__desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>
		</div>
	);
}
