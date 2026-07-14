import { Button } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

export default function WizardStep({
	stepNumber,
	totalSteps,
	title,
	description,
	children,
	onNext,
	onBack,
	onSkip,
	nextLabel,
	isLastStep,
	canProceed = true,
}) {
	return (
		<div className="sw-step">
			<div className="sw-step__progress">
				<div className="sw-step__progress-bar">
					<div
						className="sw-step__progress-fill"
						style={{ width: `${(stepNumber / totalSteps) * 100}%` }}
					/>
				</div>
				<span className="sw-step__progress-text">
					{stepNumber} / {totalSteps}
				</span>
			</div>

			<div className="sw-step__header">
				<h2 className="sw-step__title">{title}</h2>
				{description && (
					<p className="sw-step__description">{description}</p>
				)}
			</div>

			<div className="sw-step__content">{children}</div>

			<div className="sw-step__actions">
				<div className="sw-step__actions-left">
					{stepNumber > 1 && (
						<Button variant="tertiary" onClick={onBack}>
							{__("Back", "sustainable-theme")}
						</Button>
					)}
				</div>
				<div className="sw-step__actions-right">
					{onSkip && (
						<Button variant="tertiary" onClick={onSkip}>
							{__("Skip", "sustainable-theme")}
						</Button>
					)}
					<Button
						variant="primary"
						onClick={onNext}
						disabled={!canProceed}
						className="sw-step__next-btn"
					>
						{nextLabel ||
							(isLastStep
								? __("Finish & Apply", "sustainable-theme")
								: __("Continue", "sustainable-theme"))}
					</Button>
				</div>
			</div>
		</div>
	);
}
