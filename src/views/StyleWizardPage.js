import { __ } from "@wordpress/i18n";
import { useEffect, useState, useCallback } from "@wordpress/element";
import { Button, Spinner, Notice } from "@wordpress/components";
import PageWrapper from "../components/PageWrapper";
import PageBody from "../components/PageBody";
import PageTitle from "../components/PageTitle";
import PageHeader from "../components/PageHeader";
import Text from "../components/Text";
import WizardStep from "../components/style-wizard/WizardStep";
import StepIdentity from "../components/style-wizard/StepIdentity";
import StepPalette from "../components/style-wizard/StepPalette";
import StepTypography from "../components/style-wizard/StepTypography";
import StepLayout from "../components/style-wizard/StepLayout";
import StepShape from "../components/style-wizard/StepShape";
import StepAnimation from "../components/style-wizard/StepAnimation";
import StepReview from "../components/style-wizard/StepReview";
import Lookbook from "../components/style-wizard/Lookbook";

const TOTAL_STEPS = 7;

export default function StyleWizardPage() {
	const [step, setStep] = useState(0);
	const [settings, setSettings] = useState(null);
	const [palettes, setPalettes] = useState([]);
	const [identities, setIdentities] = useState([]);
	const [isLoading, setIsLoading] = useState(true);
	const [isSaving, setIsSaving] = useState(false);
	const [saveMessage, setSaveMessage] = useState("");
	const [saveStatus, setSaveStatus] = useState("");
	const [wizardMode, setWizardMode] = useState("idle"); // idle | wizard | completed

	useEffect(() => {
		const load = async () => {
			try {
				const response = await fetch(
					"/wp-json/sustainable-theme/v1/style-wizard",
					{
						headers: {
							"X-WP-Nonce": window.wpApiSettings?.nonce || "",
						},
					},
				);
				if (!response.ok) return;
				const data = await response.json();
				setSettings(data.settings);
				setPalettes(data.palettes || []);
				setIdentities(data.identities || []);

				if (data.settings.wizard_completed) {
					setWizardMode("completed");
				}
			} catch (err) {
				console.error("Failed to load style wizard settings:", err);
			} finally {
				setIsLoading(false);
			}
		};
		load();
	}, []);

	const updateSettings = useCallback((partial) => {
		setSettings((prev) => ({ ...prev, ...partial }));
	}, []);

	const handleSave = async () => {
		setIsSaving(true);
		setSaveMessage("");
		try {
			const response = await fetch(
				"/wp-json/sustainable-theme/v1/style-wizard",
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-WP-Nonce": window.wpApiSettings?.nonce || "",
					},
					body: JSON.stringify({
						settings: { ...settings, wizard_completed: true },
					}),
				},
			);
			const data = await response.json();
			if (data.success) {
				setSettings(data.settings);
				setWizardMode("completed");
				setSaveMessage(
					__("Your style has been applied!", "sustainable-theme"),
				);
				setSaveStatus("success");
			} else {
				setSaveMessage(
					data.message ||
						__("Failed to save.", "sustainable-theme"),
				);
				setSaveStatus("error");
			}
		} catch {
			setSaveMessage(
				__("Network error while saving.", "sustainable-theme"),
			);
			setSaveStatus("error");
		} finally {
			setIsSaving(false);
			setTimeout(() => {
				setSaveMessage("");
				setSaveStatus("");
			}, 5000);
		}
	};

	const handleReset = async () => {
		if (
			!window.confirm(
				__(
					"Are you sure? This will reset all style wizard settings to defaults.",
					"sustainable-theme",
				),
			)
		) {
			return;
		}

		try {
			const response = await fetch(
				"/wp-json/sustainable-theme/v1/style-wizard/reset",
				{
					method: "POST",
					headers: {
						"X-WP-Nonce": window.wpApiSettings?.nonce || "",
					},
				},
			);
			const data = await response.json();
			if (data.success) {
				setSettings(data.settings);
				setWizardMode("idle");
				setStep(0);
			}
		} catch {
			/* silent */
		}
	};

	if (isLoading || !settings) {
		return (
			<PageWrapper>
				<PageBody>
					<div style={{ display: "flex", justifyContent: "center", padding: "60px" }}>
						<Spinner />
					</div>
				</PageBody>
			</PageWrapper>
		);
	}

	// Completed state — show lookbook + edit options
	if (wizardMode === "completed") {
		return (
			<PageWrapper>
				<PageHeader>
					<PageTitle>
						{__("Style Wizard", "sustainable-theme")}
					</PageTitle>
					<Text>
						{__(
							"Your visual identity is configured. Here's a preview of your current style.",
							"sustainable-theme",
						)}
					</Text>
				</PageHeader>
				<PageBody>
					{saveMessage && (
						<Notice
							status={saveStatus}
							isDismissible={false}
							style={{ marginBottom: "20px" }}
						>
							{saveMessage}
						</Notice>
					)}

					<Lookbook settings={settings} />

					<div
						style={{
							display: "flex",
							gap: "12px",
							marginTop: "24px",
						}}
					>
						<Button
							variant="primary"
							onClick={() => {
								setWizardMode("wizard");
								setStep(1);
							}}
						>
							{__("Edit Style", "sustainable-theme")}
						</Button>
						<Button variant="tertiary" onClick={handleReset} isDestructive>
							{__("Reset to Defaults", "sustainable-theme")}
						</Button>
					</div>
				</PageBody>
			</PageWrapper>
		);
	}

	// Idle state — welcome screen
	if (wizardMode === "idle" && step === 0) {
		return (
			<PageWrapper>
				<PageHeader>
					<PageTitle>
						{__("Style Wizard", "sustainable-theme")}
					</PageTitle>
				</PageHeader>
				<PageBody>
					<div className="sw-welcome">
						<div className="sw-welcome__content">
							<h2 className="sw-welcome__heading">
								{__(
									"Define your visual identity",
									"sustainable-theme",
								)}
							</h2>
							<p className="sw-welcome__text">
								{__(
									"This wizard will walk you through creating a cohesive design system for your website. Choose colors, typography, layout rhythms, shapes, and animations — see everything come together in a live preview.",
									"sustainable-theme",
								)}
							</p>
							<div className="sw-welcome__steps">
								<div className="sw-welcome__step-item">
									<span className="sw-welcome__step-num">1</span>
									<span>{__("Color Palette", "sustainable-theme")}</span>
								</div>
								<div className="sw-welcome__step-item">
									<span className="sw-welcome__step-num">2</span>
									<span>{__("Typography", "sustainable-theme")}</span>
								</div>
								<div className="sw-welcome__step-item">
									<span className="sw-welcome__step-num">3</span>
									<span>{__("Layout & Rhythm", "sustainable-theme")}</span>
								</div>
								<div className="sw-welcome__step-item">
									<span className="sw-welcome__step-num">4</span>
									<span>{__("Shapes & Depth", "sustainable-theme")}</span>
								</div>
								<div className="sw-welcome__step-item">
									<span className="sw-welcome__step-num">5</span>
									<span>{__("Animations", "sustainable-theme")}</span>
								</div>
								<div className="sw-welcome__step-item">
									<span className="sw-welcome__step-num">6</span>
									<span>{__("Review & Apply", "sustainable-theme")}</span>
								</div>
							</div>
							<Button
								variant="primary"
								className="sw-welcome__btn"
								onClick={() => {
									setWizardMode("wizard");
									setStep(1);
								}}
							>
								{__("Start Style Wizard", "sustainable-theme")}
							</Button>
						</div>
						<div className="sw-welcome__preview">
							<Lookbook settings={settings} />
						</div>
					</div>
				</PageBody>
			</PageWrapper>
		);
	}

	// Active wizard steps
	const stepConfig = {
		1: {
			title: __("Choose a Visual Identity", "sustainable-theme"),
			description: __(
				"Pick a starting point that matches your vibe — from minimalist to brutalist. You'll refine everything in the next steps.",
				"sustainable-theme",
			),
			component: (
				<StepIdentity
					settings={settings}
					identities={identities}
					onChange={updateSettings}
				/>
			),
		},
		2: {
			title: __("Color Palette", "sustainable-theme"),
			description: __(
				"Colors set the emotional tone for your brand. Pick a curated palette or create your own.",
				"sustainable-theme",
			),
			component: (
				<StepPalette
					settings={settings}
					palettes={palettes}
					onChange={updateSettings}
				/>
			),
		},
		3: {
			title: __("Typography & Character", "sustainable-theme"),
			description: __(
				"Fonts, weight, spacing and scale define your brand's voice — from whisper-light to brutally heavy.",
				"sustainable-theme",
			),
			component: (
				<StepTypography
					settings={settings}
					onChange={updateSettings}
				/>
			),
		},
		4: {
			title: __("Layout & Visual Rhythm", "sustainable-theme"),
			description: __(
				"Define how sections flow — from dense brutalist stacking to luxurious editorial spacing.",
				"sustainable-theme",
			),
			component: (
				<StepLayout settings={settings} onChange={updateSettings} />
			),
		},
		5: {
			title: __("Shapes & Depth", "sustainable-theme"),
			description: __(
				"Corners, shadows, and borders define the tactile quality of your design.",
				"sustainable-theme",
			),
			component: (
				<StepShape settings={settings} onChange={updateSettings} />
			),
		},
		6: {
			title: __("Animation & Motion", "sustainable-theme"),
			description: __(
				"Motion brings pages to life — or leave it raw and static for maximum impact.",
				"sustainable-theme",
			),
			component: (
				<StepAnimation
					settings={settings}
					onChange={updateSettings}
				/>
			),
		},
		7: {
			title: __("Review Your Style", "sustainable-theme"),
			description: __(
				"Here's everything together. Click 'Finish & Apply' to save your design system.",
				"sustainable-theme",
			),
			component: <StepReview settings={settings} />,
		},
	};

	const current = stepConfig[step];

	return (
		<PageWrapper>
			<PageHeader>
				<PageTitle>
					{__("Style Wizard", "sustainable-theme")}
				</PageTitle>
			</PageHeader>
			<PageBody>
				{saveMessage && (
					<Notice
						status={saveStatus}
						isDismissible={false}
						style={{ marginBottom: "20px" }}
					>
						{saveMessage}
					</Notice>
				)}

				<WizardStep
					stepNumber={step}
					totalSteps={TOTAL_STEPS}
					title={current.title}
					description={current.description}
					onNext={() => {
						if (step === TOTAL_STEPS) {
							handleSave();
						} else {
							setStep((s) => s + 1);
						}
					}}
					onBack={() => setStep((s) => s - 1)}
					onSkip={
						step < TOTAL_STEPS
							? () => setStep((s) => s + 1)
							: undefined
					}
					isLastStep={step === TOTAL_STEPS}
					nextLabel={
						isSaving
							? __("Saving…", "sustainable-theme")
							: undefined
					}
				>
					{current.component}
				</WizardStep>
			</PageBody>
		</PageWrapper>
	);
}
