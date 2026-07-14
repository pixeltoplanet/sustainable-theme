import { __ } from "@wordpress/i18n";
import { useMemo } from "@wordpress/element";

const RADIUS_MAP = {
	none: "0",
	subtle: "4px",
	soft: "12px",
	rounded: "20px",
	pill: "9999px",
};

const SHADOW_MAP = {
	none: "none",
	subtle: "0 2px 8px rgba(0,0,0,.06)",
	medium: "0 4px 16px rgba(0,0,0,.1)",
	dramatic: "0 8px 30px rgba(0,0,0,.15)",
};

export default function Lookbook({ settings }) {
	const styles = useMemo(() => {
		const radius = RADIUS_MAP[settings.border_radius] || "12px";
		const cardRadius =
			settings.border_radius === "pill" ? "20px" : radius;
		const shadow = SHADOW_MAP[settings.shadow_style] || "none";

		return {
			"--lb-primary": settings.color_primary,
			"--lb-secondary": settings.color_secondary,
			"--lb-accent": settings.color_accent,
			"--lb-bg": settings.color_background,
			"--lb-surface": settings.color_surface,
			"--lb-text": settings.color_text,
			"--lb-text-muted": settings.color_text_muted,
			"--lb-radius": cardRadius,
			"--lb-btn-radius":
				settings.border_radius === "pill" ? "9999px" : radius,
			"--lb-shadow": shadow,
		};
	}, [settings]);

	const animClass =
		settings.animation_style !== "none" ? "lb--animated" : "";

	return (
		<div className={`lb ${animClass}`} style={styles}>
			<div className="lb__browser">
				<div className="lb__browser-bar">
					<span className="lb__dot lb__dot--red" />
					<span className="lb__dot lb__dot--yellow" />
					<span className="lb__dot lb__dot--green" />
					<span className="lb__browser-url">yoursite.com</span>
				</div>
				<div className="lb__viewport">
					{/* Navigation */}
					<nav className="lb__nav">
						<span className="lb__logo" />
						<div className="lb__nav-links">
							<span />
							<span />
							<span />
						</div>
					</nav>

					{/* Hero section based on hero_style */}
					<HeroSection
						heroStyle={settings.hero_style}
						settings={settings}
					/>

					{/* Content section based on content_layout */}
					<ContentSection
						layout={settings.content_layout}
						settings={settings}
					/>

					{/* Cards section */}
					<div className="lb__cards-section">
						<div className="lb__section-title" />
						<div className="lb__card-grid">
							<div className="lb__card">
								<div className="lb__card-img" />
								<div className="lb__card-body">
									<div className="lb__card-heading" />
									<div className="lb__card-text" />
									<div className="lb__card-text lb__card-text--short" />
								</div>
							</div>
							<div className="lb__card">
								<div className="lb__card-img" />
								<div className="lb__card-body">
									<div className="lb__card-heading" />
									<div className="lb__card-text" />
									<div className="lb__card-text lb__card-text--short" />
								</div>
							</div>
							<div className="lb__card">
								<div className="lb__card-img" />
								<div className="lb__card-body">
									<div className="lb__card-heading" />
									<div className="lb__card-text" />
									<div className="lb__card-text lb__card-text--short" />
								</div>
							</div>
						</div>
					</div>

					{/* CTA */}
					<div className="lb__cta">
						<div className="lb__cta-heading" />
						<div className="lb__cta-text" />
						<div className="lb__cta-btn" />
					</div>
				</div>
			</div>

			<p className="lb__caption">
				{__("Live preview — updates as you make changes", "sustainable-theme")}
			</p>
		</div>
	);
}

function HeroSection({ heroStyle }) {
	switch (heroStyle) {
		case "full-cover":
			return (
				<div className="lb__hero lb__hero--full">
					<div className="lb__hero-overlay">
						<div className="lb__hero-heading" />
						<div className="lb__hero-subtext" />
						<div className="lb__hero-btn" />
					</div>
				</div>
			);
		case "boxed":
			return (
				<div className="lb__hero lb__hero--boxed">
					<div className="lb__hero-box">
						<div className="lb__hero-overlay">
							<div className="lb__hero-heading" />
							<div className="lb__hero-subtext" />
							<div className="lb__hero-btn" />
						</div>
					</div>
				</div>
			);
		case "split-image":
			return (
				<div className="lb__hero lb__hero--split">
					<div className="lb__hero-text-side">
						<div className="lb__hero-heading" />
						<div className="lb__hero-subtext" />
						<div className="lb__hero-subtext lb__hero-subtext--short" />
						<div className="lb__hero-btn" />
					</div>
					<div className="lb__hero-img-side" />
				</div>
			);
		case "minimal-text":
			return (
				<div className="lb__hero lb__hero--minimal">
					<div className="lb__hero-heading lb__hero-heading--large" />
					<div className="lb__hero-subtext" />
				</div>
			);
		default:
			return null;
	}
}

function ContentSection({ layout }) {
	switch (layout) {
		case "text-first":
			return (
				<div className="lb__content lb__content--text-first">
					<div className="lb__content-heading" />
					<div className="lb__content-para" />
					<div className="lb__content-para" />
					<div className="lb__content-para lb__content-para--short" />
					<div className="lb__content-img-full" />
				</div>
			);
		case "image-beside":
			return (
				<div className="lb__content lb__content--beside">
					<div className="lb__content-row">
						<div className="lb__content-img-half" />
						<div className="lb__content-text-half">
							<div className="lb__content-heading" />
							<div className="lb__content-para" />
							<div className="lb__content-para lb__content-para--short" />
						</div>
					</div>
				</div>
			);
		case "card-grid":
			return (
				<div className="lb__content lb__content--grid">
					<div className="lb__content-heading" style={{ marginBottom: "12px" }} />
					<div className="lb__mini-grid">
						<div className="lb__mini-card" />
						<div className="lb__mini-card" />
						<div className="lb__mini-card" />
						<div className="lb__mini-card" />
					</div>
				</div>
			);
		default:
			return (
				<div className="lb__content lb__content--mixed">
					<div className="lb__content-heading" />
					<div className="lb__content-para" />
					<div className="lb__content-row">
						<div className="lb__content-img-half" />
						<div className="lb__content-text-half">
							<div className="lb__content-para" />
							<div className="lb__content-para lb__content-para--short" />
						</div>
					</div>
				</div>
			);
	}
}
