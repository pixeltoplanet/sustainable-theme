import { __ } from "@wordpress/i18n";

const IDENTITY_VISUALS = {
	minimal: {
		mockup: "minimal",
		tags: ["Clean", "Whitespace", "Understated"],
	},
	modern: {
		mockup: "modern",
		tags: ["Dynamic", "Bold", "Interactive"],
	},
	editorial: {
		mockup: "editorial",
		tags: ["Sophisticated", "Typography-led", "Refined"],
	},
	brutalist: {
		mockup: "brutalist",
		tags: ["Raw", "Heavy type", "No decoration"],
	},
	organic: {
		mockup: "organic",
		tags: ["Natural", "Warm", "Flowing"],
	},
};

function IdentityMockup({ id }) {
	const mockups = {
		minimal: (
			<div className="sw-id-mockup sw-id-mockup--minimal">
				<div className="sw-id-mockup__bar" />
				<div className="sw-id-mockup__hero">
					<div className="sw-id-mockup__line sw-id-mockup__line--thin sw-id-mockup__line--60" />
					<div className="sw-id-mockup__line sw-id-mockup__line--thin sw-id-mockup__line--30" />
				</div>
				<div className="sw-id-mockup__spacer" />
				<div className="sw-id-mockup__line sw-id-mockup__line--100" />
				<div className="sw-id-mockup__line sw-id-mockup__line--80" />
			</div>
		),
		modern: (
			<div className="sw-id-mockup sw-id-mockup--modern">
				<div className="sw-id-mockup__bar" />
				<div className="sw-id-mockup__hero sw-id-mockup__hero--filled">
					<div className="sw-id-mockup__line sw-id-mockup__line--white sw-id-mockup__line--50" />
					<div className="sw-id-mockup__btn" />
				</div>
				<div className="sw-id-mockup__cards">
					<div className="sw-id-mockup__card sw-id-mockup__card--rounded" />
					<div className="sw-id-mockup__card sw-id-mockup__card--rounded" />
					<div className="sw-id-mockup__card sw-id-mockup__card--rounded" />
				</div>
			</div>
		),
		editorial: (
			<div className="sw-id-mockup sw-id-mockup--editorial">
				<div className="sw-id-mockup__bar" />
				<div className="sw-id-mockup__split">
					<div className="sw-id-mockup__split-text">
						<div className="sw-id-mockup__line sw-id-mockup__line--serif sw-id-mockup__line--80" />
						<div className="sw-id-mockup__line sw-id-mockup__line--thin sw-id-mockup__line--60" />
					</div>
					<div className="sw-id-mockup__split-img" />
				</div>
				<div className="sw-id-mockup__spacer sw-id-mockup__spacer--lg" />
				<div className="sw-id-mockup__line sw-id-mockup__line--100" />
				<div className="sw-id-mockup__line sw-id-mockup__line--100" />
			</div>
		),
		brutalist: (
			<div className="sw-id-mockup sw-id-mockup--brutalist">
				<div className="sw-id-mockup__bar sw-id-mockup__bar--thick" />
				<div className="sw-id-mockup__hero sw-id-mockup__hero--tight">
					<div className="sw-id-mockup__line sw-id-mockup__line--heavy sw-id-mockup__line--90" />
					<div className="sw-id-mockup__line sw-id-mockup__line--heavy sw-id-mockup__line--60" />
				</div>
				<div className="sw-id-mockup__border-line" />
				<div className="sw-id-mockup__line sw-id-mockup__line--100" />
				<div className="sw-id-mockup__line sw-id-mockup__line--100" />
				<div className="sw-id-mockup__line sw-id-mockup__line--70" />
			</div>
		),
		organic: (
			<div className="sw-id-mockup sw-id-mockup--organic">
				<div className="sw-id-mockup__bar" />
				<div className="sw-id-mockup__hero sw-id-mockup__hero--boxed">
					<div className="sw-id-mockup__line sw-id-mockup__line--white sw-id-mockup__line--50" />
					<div className="sw-id-mockup__line sw-id-mockup__line--white sw-id-mockup__line--30" />
				</div>
				<div className="sw-id-mockup__spacer" />
				<div className="sw-id-mockup__row">
					<div className="sw-id-mockup__img-rounded" />
					<div className="sw-id-mockup__text-block">
						<div className="sw-id-mockup__line sw-id-mockup__line--60" />
						<div className="sw-id-mockup__line sw-id-mockup__line--100" />
						<div className="sw-id-mockup__line sw-id-mockup__line--80" />
					</div>
				</div>
			</div>
		),
	};

	return mockups[id] || null;
}

export default function StepIdentity({ settings, identities, onChange }) {
	const handleSelect = (identity) => {
		onChange({
			identity: identity.id,
			...identity.settings,
		});
	};

	return (
		<div className="sw-identity">
			<div className="sw-identity__grid">
				{identities.map((identity) => {
					const visual = IDENTITY_VISUALS[identity.id] || {};
					const isSelected = settings.identity === identity.id;

					return (
						<button
							key={identity.id}
							type="button"
							className={`sw-identity__card ${isSelected ? "sw-identity__card--selected" : ""}`}
							onClick={() => handleSelect(identity)}
						>
							<div className="sw-identity__preview">
								<IdentityMockup id={identity.id} />
							</div>
							<div className="sw-identity__info">
								<span className="sw-identity__name">
									{identity.name}
								</span>
								<span className="sw-identity__desc">
									{identity.description}
								</span>
								{visual.tags && (
									<div className="sw-identity__tags">
										{visual.tags.map((tag) => (
											<span
												key={tag}
												className="sw-identity__tag"
											>
												{tag}
											</span>
										))}
									</div>
								)}
							</div>
							{isSelected && (
								<span className="sw-identity__check">✓</span>
							)}
						</button>
					);
				})}

				<button
					type="button"
					className={`sw-identity__card sw-identity__card--custom ${settings.identity === "custom" ? "sw-identity__card--selected" : ""}`}
					onClick={() => onChange({ identity: "custom" })}
				>
					<div className="sw-identity__preview sw-identity__preview--custom">
						<span className="dashicons dashicons-admin-customizer" />
					</div>
					<div className="sw-identity__info">
						<span className="sw-identity__name">
							{__("Start from Scratch", "sustainable-theme")}
						</span>
						<span className="sw-identity__desc">
							{__(
								"Build your own identity step by step",
								"sustainable-theme",
							)}
						</span>
					</div>
					{settings.identity === "custom" && (
						<span className="sw-identity__check">✓</span>
					)}
				</button>
			</div>

			<p className="sw-identity__hint">
				{__(
					"Pick a starting point — you can refine every detail in the following steps.",
					"sustainable-theme",
				)}
			</p>
		</div>
	);
}
