import { useState, useEffect, useCallback, useMemo } from "@wordpress/element";
import { Modal, Button } from "@wordpress/components";
import { BlockPreview } from "@wordpress/block-editor";
import { useSelect, useDispatch } from "@wordpress/data";
import { parse } from "@wordpress/blocks";
import apiFetch from "@wordpress/api-fetch";

const STORAGE_KEY = "sustainable-theme-hide-template-modal";

function isModalSuppressed() {
	try {
		return localStorage.getItem(STORAGE_KEY) === "1";
	} catch {
		return false;
	}
}

function setModalSuppressed(value) {
	try {
		localStorage.setItem(STORAGE_KEY, value ? "1" : "0");
	} catch {
		/* noop */
	}
}

const PAGE_TYPES = [
	{
		id: "home",
		label: "Home Page",
		description:
			"Full landing pages with hero, services, testimonials, and CTA sections",
		dashicon: "admin-home",
		prefix: "sustainable-theme/page-home-",
	},
	{
		id: "about",
		label: "About Page",
		description:
			"Tell your story with images, team sections, values, and quotes",
		dashicon: "groups",
		prefix: "sustainable-theme/page-about-",
	},
	{
		id: "contact",
		label: "Contact Page",
		description:
			"Contact forms, information sections, and location details",
		dashicon: "email",
		prefix: "sustainable-theme/page-contact-",
	},
	{
		id: "portfolio",
		label: "Portfolio",
		description:
			"Showcase your work with grids, masonry, and project layouts",
		dashicon: "portfolio",
		prefix: "sustainable-theme/page-portfolio-",
	},
	{
		id: "blog",
		label: "Blog Overview",
		description:
			"Blog index pages with post listings and featured content",
		dashicon: "welcome-write-blog",
		prefix: "sustainable-theme/page-post-overview-",
	},
];

const PREVIEW_STYLES = [
	{
		css: `
			.wp-block-cover { min-height: 500px !important; }
			.wp-block-cover .wp-block-cover { min-height: 300px !important; }
			body { overflow: hidden !important; }
		`,
	},
];

const SLUG_LABEL_MAP = {
	hero: "Hero",
	service: "Services",
	services: "Services",
	stats: "Stats",
	content: "Content",
	testimonial: "Testimonials",
	testimonials: "Testimonials",
	posts: "Posts",
	pricing: "Pricing",
	cta: "CTA",
	contact: "Contact",
	gallery: "Gallery",
	intro: "Intro",
	footer: "Footer",
};

function slugToLabel(slug) {
	const name = slug.replace("sustainable-theme/", "");
	const first = name.split("-")[0];
	return SLUG_LABEL_MAP[first] || first.charAt(0).toUpperCase() + first.slice(1);
}

function getSectionLabels(content) {
	const labels = [];
	const seen = new Set();

	const addUnique = (label) => {
		if (!seen.has(label)) {
			seen.add(label);
			labels.push(label);
		}
	};

	// Pattern references: <!-- wp:pattern {"slug":"..."} /-->
	for (const [, slug] of content.matchAll(
		/<!-- wp:pattern \{"slug":"([^"]+)"\}/g
	)) {
		addUnique(slugToLabel(slug));
	}

	// Inline metadata: "patternName":"sustainable-theme/..."
	for (const [, slug] of content.matchAll(/"patternName":"([^"]+)"/g)) {
		addUnique(slugToLabel(slug));
	}

	// Fallback for pure-inline patterns: detect from headings
	if (labels.length === 0) {
		const headings = [
			...content.matchAll(
				/<h[1-6][^>]*>([^<]{3,40})<\/h[1-6]>/g
			),
		];
		for (const [, text] of headings.slice(0, 6)) {
			const clean = text.replace(/<[^>]*>/g, "").trim();
			if (clean) addUnique(clean);
		}
	}

	return labels;
}

function resolvePatternContent(content, allPatterns, depth = 0) {
	if (depth > 5) return content;
	return content.replace(
		/<!-- wp:pattern \{"slug":"([^"]+)"\} \/-->/g,
		(_, slug) => {
			const p = allPatterns.find((pat) => pat.name === slug);
			return p
				? resolvePatternContent(p.content, allPatterns, depth + 1)
				: "";
		}
	);
}

function getVariantLabel(pattern, index) {
	const match = pattern.name.match(/(\d+)$/);
	return match ? `Style ${parseInt(match[1], 10)}` : `Style ${index + 1}`;
}

// ── Skeleton loader ─────────────────────────────────────────────

const SkeletonCard = () => (
	<div className="sptm-skeleton-card">
		<div className="sptm-skeleton-icon" />
		<div className="sptm-skeleton-line sptm-skeleton-line--md" />
		<div className="sptm-skeleton-line sptm-skeleton-line--lg" />
		<div className="sptm-skeleton-line sptm-skeleton-line--lg" />
		<div className="sptm-skeleton-line sptm-skeleton-line--sm" />
	</div>
);

const LoadingSkeleton = () => (
	<div className="sptm-step">
		<div className="sptm-skeleton-line sptm-skeleton-line--xl" style={{ marginBottom: 24 }} />
		<div className="sptm-type-grid">
			{Array.from({ length: 5 }, (_, i) => (
				<SkeletonCard key={i} />
			))}
		</div>
	</div>
);

// ── Pattern preview ─────────────────────────────────────────────

const PatternPreview = ({ pattern, allPatterns }) => {
	const blocks = useMemo(() => {
		const resolved = resolvePatternContent(
			pattern.content,
			allPatterns
		);
		return parse(resolved);
	}, [pattern.content, allPatterns]);

	if (!blocks.length) return null;

	return (
		<div className="sptm-preview-wrap">
			<BlockPreview
				blocks={blocks}
				viewportWidth={1200}
				additionalStyles={PREVIEW_STYLES}
			/>
		</div>
	);
};

// ── Section pills ───────────────────────────────────────────────

const SectionPills = ({ content }) => {
	const labels = useMemo(() => getSectionLabels(content), [content]);
	if (!labels.length) return null;

	return (
		<div className="sptm-pills">
			{labels.map((label) => (
				<span key={label} className="sptm-pill">
					{label}
				</span>
			))}
		</div>
	);
};

// ── Main modal ──────────────────────────────────────────────────

const PageTemplateModal = () => {
	const [dismissed, setDismissed] = useState(() => isModalSuppressed());
	const [step, setStep] = useState(1);
	const [selectedType, setSelectedType] = useState(null);
	const [allPatterns, setAllPatterns] = useState(null);
	const [loading, setLoading] = useState(true);
	const [dontShowAgain, setDontShowAgain] = useState(false);

	const { postType, content, postId } = useSelect((select) => {
		const editor = select("core/editor");
		return {
			postType: editor.getCurrentPostType(),
			content: editor.getEditedPostContent(),
			postId: editor.getCurrentPostId(),
		};
	});

	const { resetBlocks } = useDispatch("core/block-editor");

	const shouldShow =
		postType === "page" && !!postId && (!content || !content.trim());
	const isOpen = shouldShow && !dismissed;

	useEffect(() => {
		if (!isOpen) return;
		apiFetch({ path: "/wp/v2/block-patterns/patterns" })
			.then((patterns) => {
				setAllPatterns(patterns);
				setLoading(false);
			})
			.catch(() => setLoading(false));
	}, [isOpen]);

	const pagePatterns = useMemo(() => {
		if (!allPatterns) return [];
		return allPatterns.filter((p) =>
			p.name.startsWith("sustainable-theme/page-")
		);
	}, [allPatterns]);

	const getTypePatterns = useCallback(
		(type) => pagePatterns.filter((p) => p.name.startsWith(type.prefix)),
		[pagePatterns]
	);

	const typesWithPatterns = useMemo(
		() => PAGE_TYPES.filter((type) => getTypePatterns(type).length > 0),
		[getTypePatterns]
	);

	const handleTypeSelect = useCallback((type) => {
		setSelectedType(type);
		setStep(2);
	}, []);

	const handleInsert = useCallback(
		(pattern) => {
			const resolved = resolvePatternContent(
				pattern.content,
				allPatterns
			);
			const blocks = parse(resolved);
			resetBlocks(blocks);
			setDismissed(true);
		},
		[allPatterns, resetBlocks]
	);

	const handleClose = useCallback(() => {
		if (dontShowAgain) setModalSuppressed(true);
		setDismissed(true);
	}, [dontShowAgain]);

	const handleBack = useCallback(() => {
		setStep(1);
		setSelectedType(null);
	}, []);

	if (!isOpen) return null;

	const currentPatterns = selectedType ? getTypePatterns(selectedType) : [];

	return (
		<Modal
			title={
				step === 1
					? "Start with a template"
					: `Choose a ${selectedType.label} template`
			}
			onRequestClose={handleClose}
			className={`sptm-modal ${step === 2 ? "sptm-modal--wide" : ""}`}
			isDismissible
			shouldCloseOnClickOutside={false}
		>
			{loading ? (
				<LoadingSkeleton />
			) : step === 1 ? (
				<div className="sptm-step">
					<p className="sptm-subtitle">
						Choose a page type to get started, or start with a blank
						page.
					</p>
					<div className="sptm-type-grid">
						{typesWithPatterns.map((type) => {
							const count = getTypePatterns(type).length;
							return (
								<button
									key={type.id}
									className="sptm-type-card"
									onClick={() => handleTypeSelect(type)}
									type="button"
								>
									<span
										className={`sptm-type-icon dashicons dashicons-${type.dashicon}`}
									/>
									<span className="sptm-type-label">
										{type.label}
									</span>
									<span className="sptm-type-desc">
										{type.description}
									</span>
									<span className="sptm-type-count">
										{count}{" "}
										{count === 1
											? "template"
											: "templates"}
									</span>
								</button>
							);
						})}

						{/* Blank page option */}
						<button
							className="sptm-type-card sptm-type-card--blank"
							onClick={handleClose}
							type="button"
						>
							<span className="sptm-type-icon dashicons dashicons-editor-contract" />
							<span className="sptm-type-label">
								Blank Page
							</span>
							<span className="sptm-type-desc">
								Start from scratch with an empty canvas
							</span>
						</button>
					</div>

					<label className="sptm-dont-show">
						<input
							type="checkbox"
							checked={dontShowAgain}
							onChange={(e) =>
								setDontShowAgain(e.target.checked)
							}
						/>
						Don&apos;t show this again for new pages
					</label>
				</div>
			) : (
				<div className="sptm-step">
					<div className="sptm-step-header">
						<Button
							variant="tertiary"
							onClick={handleBack}
							icon="arrow-left-alt2"
							size="small"
						>
							All page types
						</Button>
					</div>
					<p className="sptm-subtitle">
						Browse the previews, then click &ldquo;Use
						template&rdquo; to insert.
					</p>
					<div className="sptm-pattern-grid">
						{currentPatterns.map((pattern, i) => (
							<div
								key={pattern.name}
								className="sptm-pattern-card"
							>
								<PatternPreview
									pattern={pattern}
									allPatterns={allPatterns}
								/>
								<div className="sptm-pattern-info">
									<span className="sptm-pattern-title">
										{getVariantLabel(pattern, i)}
									</span>
									<span className="sptm-pattern-desc">
										{pattern.description}
									</span>
									<SectionPills
										content={pattern.content}
									/>
									<Button
										variant="secondary"
										className="sptm-pattern-btn"
										onClick={() =>
											handleInsert(pattern)
										}
									>
										Use template
									</Button>
								</div>
							</div>
						))}
					</div>
				</div>
			)}
		</Modal>
	);
};

export default PageTemplateModal;
