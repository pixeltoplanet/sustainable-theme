import { __ } from "@wordpress/i18n";

const HERO_OPTIONS = [
	{
		id: "full-cover",
		label: "Full Cover",
		description: "Full-width hero image with overlay text — bold, immersive",
	},
	{
		id: "boxed",
		label: "Boxed Hero",
		description: "Contained hero with rounded edges — polished, structured",
	},
	{
		id: "split-image",
		label: "Split Image",
		description: "Text on one side, image on the other — balanced, editorial",
	},
	{
		id: "minimal-text",
		label: "Minimal Text",
		description: "Large typography, no image — fast loading, content-focused",
	},
	{
		id: "oversized-type",
		label: "Oversized Type",
		description: "Massive headline dominating the viewport — raw, statement",
	},
];

const CONTENT_OPTIONS = [
	{
		id: "text-first",
		label: "Text First",
		description: "Long-form reading with supporting visuals below",
	},
	{
		id: "image-beside",
		label: "Image Beside Text",
		description: "Alternating image/text rows — storytelling, case studies",
	},
	{
		id: "mixed",
		label: "Mixed Sections",
		description: "Variety of section types — dynamic, engaging pages",
	},
	{
		id: "card-grid",
		label: "Card Grid",
		description: "Grid of cards — services, portfolio, team members",
	},
	{
		id: "stacked-full",
		label: "Stacked Full-Width",
		description: "Full-bleed sections stacked vertically — raw, impactful",
	},
];

const SPACING_OPTIONS = [
	{
		id: "dense",
		label: "Dense",
		description: "Minimal gaps, raw stacking — brutalist energy",
		gap: "40px",
	},
	{
		id: "compact",
		label: "Compact",
		description: "Tight but readable, information-dense",
		gap: "56px",
	},
	{
		id: "comfortable",
		label: "Comfortable",
		description: "Balanced whitespace, easy scanning",
		gap: "80px",
	},
	{
		id: "spacious",
		label: "Spacious",
		description: "Generous breathing room, luxury feel",
		gap: "120px",
	},
	{
		id: "editorial",
		label: "Editorial",
		description: "Maximum whitespace, dramatic pauses between content",
		gap: "160px",
	},
];

const CONTENT_WIDTH_OPTIONS = [
	{
		id: "narrow",
		label: "Narrow (720px)",
		description: "Focused reading, long-form friendly",
	},
	{
		id: "default",
		label: "Default (900px)",
		description: "Standard content width, balanced",
	},
	{
		id: "wide",
		label: "Wide (1200px)",
		description: "Expansive, great for grids and visuals",
	},
	{
		id: "full-bleed",
		label: "Full Bleed",
		description: "Edge-to-edge, no margins — raw, immersive",
	},
];

const RHYTHM_OPTIONS = [
	{
		id: "tight",
		label: "Tight",
		description: "Minimal space between elements — dense, information-packed",
	},
	{
		id: "balanced",
		label: "Balanced",
		description: "Standard spacing between paragraphs and headings",
	},
	{
		id: "dramatic",
		label: "Dramatic",
		description: "Large gaps before headings, content breathes heavily",
	},
];

function LayoutMockup({ type, isHero }) {
	if (isHero) {
		const heroMockups = {
			"full-cover": (
				<div className="sw-mockup sw-mockup--hero-full">
					<div className="sw-mockup__bg" />
					<div className="sw-mockup__overlay">
						<div className="sw-mockup__line sw-mockup__line--lg" />
						<div className="sw-mockup__line sw-mockup__line--sm" />
					</div>
				</div>
			),
			boxed: (
				<div className="sw-mockup sw-mockup--hero-boxed">
					<div className="sw-mockup__box">
						<div className="sw-mockup__bg" />
						<div className="sw-mockup__overlay">
							<div className="sw-mockup__line sw-mockup__line--lg" />
							<div className="sw-mockup__line sw-mockup__line--sm" />
						</div>
					</div>
				</div>
			),
			"split-image": (
				<div className="sw-mockup sw-mockup--hero-split">
					<div className="sw-mockup__text-side">
						<div className="sw-mockup__line sw-mockup__line--lg" />
						<div className="sw-mockup__line sw-mockup__line--md" />
						<div className="sw-mockup__line sw-mockup__line--sm" />
					</div>
					<div className="sw-mockup__image-side">
						<div className="sw-mockup__bg" />
					</div>
				</div>
			),
			"minimal-text": (
				<div className="sw-mockup sw-mockup--hero-minimal">
					<div className="sw-mockup__line sw-mockup__line--xl" />
					<div className="sw-mockup__line sw-mockup__line--md" />
				</div>
			),
		};
		return heroMockups[type] || null;
	}

	const contentMockups = {
		"text-first": (
			<div className="sw-mockup sw-mockup--content-text">
				<div className="sw-mockup__line sw-mockup__line--lg" />
				<div className="sw-mockup__line sw-mockup__line--full" />
				<div className="sw-mockup__line sw-mockup__line--full" />
				<div className="sw-mockup__line sw-mockup__line--md" />
				<div className="sw-mockup__img-block" />
			</div>
		),
		"image-beside": (
			<div className="sw-mockup sw-mockup--content-beside">
				<div className="sw-mockup__row">
					<div className="sw-mockup__img-block" />
					<div className="sw-mockup__text-block">
						<div className="sw-mockup__line sw-mockup__line--lg" />
						<div className="sw-mockup__line sw-mockup__line--full" />
						<div className="sw-mockup__line sw-mockup__line--md" />
					</div>
				</div>
				<div className="sw-mockup__row sw-mockup__row--reverse">
					<div className="sw-mockup__img-block" />
					<div className="sw-mockup__text-block">
						<div className="sw-mockup__line sw-mockup__line--lg" />
						<div className="sw-mockup__line sw-mockup__line--full" />
						<div className="sw-mockup__line sw-mockup__line--md" />
					</div>
				</div>
			</div>
		),
		mixed: (
			<div className="sw-mockup sw-mockup--content-mixed">
				<div className="sw-mockup__line sw-mockup__line--lg" />
				<div className="sw-mockup__line sw-mockup__line--full" />
				<div className="sw-mockup__row">
					<div className="sw-mockup__img-block" />
					<div className="sw-mockup__text-block">
						<div className="sw-mockup__line sw-mockup__line--full" />
						<div className="sw-mockup__line sw-mockup__line--md" />
					</div>
				</div>
			</div>
		),
		"card-grid": (
			<div className="sw-mockup sw-mockup--content-cards">
				<div className="sw-mockup__card" />
				<div className="sw-mockup__card" />
				<div className="sw-mockup__card" />
			</div>
		),
	};
	return contentMockups[type] || null;
}

export default function StepLayout({ settings, onChange }) {
	return (
		<div className="sw-layout">
			<div className="sw-layout__section">
				<h4 className="sw-layout__section-title">
					{__("Hero Style", "sustainable-theme")}
				</h4>
				<p className="sw-layout__section-desc">
					{__(
						"How should the top of your pages look? This sets the visual tone for first impressions.",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-layout__grid">
					{HERO_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-layout__card ${settings.hero_style === option.id ? "sw-layout__card--selected" : ""}`}
							onClick={() =>
								onChange({ hero_style: option.id })
							}
						>
							<div className="sw-layout__card-preview">
								<LayoutMockup type={option.id} isHero />
							</div>
							<span className="sw-layout__card-label">
								{option.label}
							</span>
							<span className="sw-layout__card-desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>

			<div className="sw-layout__section">
				<h4 className="sw-layout__section-title">
					{__("Content Rhythm", "sustainable-theme")}
				</h4>
				<p className="sw-layout__section-desc">
					{__(
						"How do you prefer to structure your page content?",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-layout__grid">
					{CONTENT_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-layout__card ${settings.content_layout === option.id ? "sw-layout__card--selected" : ""}`}
							onClick={() =>
								onChange({ content_layout: option.id })
							}
						>
							<div className="sw-layout__card-preview">
								<LayoutMockup type={option.id} />
							</div>
							<span className="sw-layout__card-label">
								{option.label}
							</span>
							<span className="sw-layout__card-desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>

			<div className="sw-layout__section">
				<h4 className="sw-layout__section-title">
					{__("Content Width", "sustainable-theme")}
				</h4>
				<p className="sw-layout__section-desc">
					{__(
						"How wide should your content column be? Narrow for reading, full-bleed for immersion.",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-layout__spacing-grid sw-layout__spacing-grid--4">
					{CONTENT_WIDTH_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-layout__spacing-card ${settings.content_width === option.id ? "sw-layout__spacing-card--selected" : ""}`}
							onClick={() =>
								onChange({ content_width: option.id })
							}
						>
							<div className="sw-layout__width-preview" data-width={option.id}>
								<span />
							</div>
							<span className="sw-layout__spacing-label">
								{option.label}
							</span>
							<span className="sw-layout__spacing-desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>

			<div className="sw-layout__section">
				<h4 className="sw-layout__section-title">
					{__("Section Density", "sustainable-theme")}
				</h4>
				<p className="sw-layout__section-desc">
					{__(
						"How much space between major page sections? Dense feels raw and packed, editorial feels luxurious.",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-layout__spacing-grid sw-layout__spacing-grid--5">
					{SPACING_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-layout__spacing-card ${settings.spacing_scale === option.id ? "sw-layout__spacing-card--selected" : ""}`}
							onClick={() =>
								onChange({
									spacing_scale: option.id,
									section_gap: option.gap,
								})
							}
						>
							<div className="sw-layout__spacing-preview">
								<div
									className="sw-layout__spacing-bars"
									data-density={option.id}
								>
									<span />
									<span />
									<span />
									<span />
								</div>
							</div>
							<span className="sw-layout__spacing-label">
								{option.label}
							</span>
							<span className="sw-layout__spacing-desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>

			<div className="sw-layout__section">
				<h4 className="sw-layout__section-title">
					{__("Vertical Rhythm", "sustainable-theme")}
				</h4>
				<p className="sw-layout__section-desc">
					{__(
						"Spacing between elements within a section — paragraphs, headings, images.",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-layout__spacing-grid">
					{RHYTHM_OPTIONS.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-layout__spacing-card ${settings.vertical_rhythm === option.id ? "sw-layout__spacing-card--selected" : ""}`}
							onClick={() =>
								onChange({ vertical_rhythm: option.id })
							}
						>
							<span className="sw-layout__spacing-label">
								{option.label}
							</span>
							<span className="sw-layout__spacing-desc">
								{option.description}
							</span>
						</button>
					))}
				</div>
			</div>
		</div>
	);
}
