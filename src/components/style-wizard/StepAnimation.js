import { __ } from "@wordpress/i18n";

const ANIMATION_STYLES = [
	{
		id: "none",
		label: "None",
		description: "No animations — fastest load, maximum accessibility",
		icon: "minus",
	},
	{
		id: "subtle",
		label: "Subtle",
		description: "Gentle fade-ins and soft movements — professional, calm",
		icon: "visibility",
	},
	{
		id: "playful",
		label: "Playful",
		description: "Bouncy entrances and lively transitions — engaging, fun",
		icon: "smiley",
	},
	{
		id: "dramatic",
		label: "Dramatic",
		description: "Bold reveals and sweeping motions — cinematic, impactful",
		icon: "star-filled",
	},
];

const TRIGGER_OPTIONS = [
	{
		id: "load",
		label: "On Page Load",
		description: "Animate elements when the page first loads",
	},
	{
		id: "scroll",
		label: "On Scroll",
		description: "Reveal elements as the user scrolls down",
	},
	{
		id: "hover",
		label: "On Hover",
		description: "Animate only when the user hovers over elements",
	},
	{
		id: "combined",
		label: "Combined",
		description: "Scroll reveals + hover interactions together",
	},
];

const SPEED_OPTIONS = [
	{ id: "slow", label: "Slow", description: "Relaxed, contemplative feel", ms: "600ms" },
	{ id: "normal", label: "Normal", description: "Balanced, natural timing", ms: "350ms" },
	{ id: "fast", label: "Fast", description: "Snappy, responsive feel", ms: "200ms" },
];

function AnimationPreview({ style }) {
	const getAnimation = () => {
		switch (style) {
			case "subtle":
				return "sw-anim-fade";
			case "playful":
				return "sw-anim-bounce";
			case "dramatic":
				return "sw-anim-slide";
			default:
				return "";
		}
	};

	return (
		<div className={`sw-animation__demo ${getAnimation()}`}>
			<div className="sw-animation__demo-card">
				<div className="sw-animation__demo-img" />
				<div className="sw-animation__demo-lines">
					<span />
					<span />
				</div>
			</div>
		</div>
	);
}

export default function StepAnimation({ settings, onChange }) {
	return (
		<div className="sw-animation">
			<div className="sw-animation__section">
				<h4 className="sw-animation__section-title">
					{__("Animation Style", "sustainable-theme")}
				</h4>
				<p className="sw-animation__section-desc">
					{__(
						"How should elements come to life on your pages?",
						"sustainable-theme",
					)}
				</p>
				<div className="sw-animation__grid">
					{ANIMATION_STYLES.map((option) => (
						<button
							key={option.id}
							type="button"
							className={`sw-animation__card ${settings.animation_style === option.id ? "sw-animation__card--selected" : ""}`}
							onClick={() =>
								onChange({ animation_style: option.id })
							}
						>
							<div className="sw-animation__card-icon">
								<span
									className={`dashicons dashicons-${option.icon}`}
								/>
							</div>
							<span className="sw-animation__card-label">
								{option.label}
							</span>
							<span className="sw-animation__card-desc">
								{option.description}
							</span>
						</button>
					))}
				</div>

				{settings.animation_style !== "none" && (
					<AnimationPreview style={settings.animation_style} />
				)}
			</div>

			{settings.animation_style !== "none" && (
				<>
					<div className="sw-animation__section">
						<h4 className="sw-animation__section-title">
							{__("Trigger", "sustainable-theme")}
						</h4>
						<div className="sw-animation__option-row">
							{TRIGGER_OPTIONS.map((option) => (
								<button
									key={option.id}
									type="button"
									className={`sw-animation__pill ${settings.animation_trigger === option.id ? "sw-animation__pill--selected" : ""}`}
									onClick={() =>
										onChange({
											animation_trigger: option.id,
										})
									}
								>
									<span className="sw-animation__pill-label">
										{option.label}
									</span>
									<span className="sw-animation__pill-desc">
										{option.description}
									</span>
								</button>
							))}
						</div>
					</div>

					<div className="sw-animation__section">
						<h4 className="sw-animation__section-title">
							{__("Speed", "sustainable-theme")}
						</h4>
						<div className="sw-animation__speed-row">
							{SPEED_OPTIONS.map((option) => (
								<button
									key={option.id}
									type="button"
									className={`sw-animation__speed-btn ${settings.animation_speed === option.id ? "sw-animation__speed-btn--selected" : ""}`}
									onClick={() =>
										onChange({
											animation_speed: option.id,
										})
									}
								>
									<span className="sw-animation__speed-label">
										{option.label}
									</span>
									<span className="sw-animation__speed-ms">
										{option.ms}
									</span>
								</button>
							))}
						</div>
					</div>
				</>
			)}

			<div className="sw-animation__note">
				<span className="dashicons dashicons-info-outline" />
				<p>
					{__(
						"Animations respect the user's reduced-motion preference. When prefers-reduced-motion is enabled, animations are automatically disabled for accessibility.",
						"sustainable-theme",
					)}
				</p>
			</div>
		</div>
	);
}
