import { __ } from "@wordpress/i18n";
import { ColorPicker } from "@wordpress/components";
import { useState } from "@wordpress/element";

function SwatchRow({ colors }) {
	return (
		<div className="sw-swatch-row">
			{Object.entries(colors).map(([key, value]) => (
				<span
					key={key}
					className="sw-swatch"
					style={{ backgroundColor: value }}
					title={key}
				/>
			))}
		</div>
	);
}

export default function StepPalette({ settings, palettes, onChange }) {
	const [customEditing, setCustomEditing] = useState(null);

	const handlePaletteSelect = (palette) => {
		onChange({
			palette_id: palette.id,
			color_primary: palette.colors.primary,
			color_secondary: palette.colors.secondary,
			color_accent: palette.colors.accent,
			color_background: palette.colors.background,
			color_surface: palette.colors.surface,
			color_text: palette.colors.text,
			color_text_muted: palette.colors.text_muted,
		});
	};

	const handleCustomColor = (key, value) => {
		onChange({ [key]: value });
	};

	const isSelected = (paletteId) => settings.palette_id === paletteId;

	const customColors = [
		{ key: "color_primary", label: __("Primary", "sustainable-theme") },
		{ key: "color_secondary", label: __("Secondary", "sustainable-theme") },
		{ key: "color_accent", label: __("Accent", "sustainable-theme") },
		{ key: "color_background", label: __("Background", "sustainable-theme") },
		{ key: "color_surface", label: __("Surface", "sustainable-theme") },
		{ key: "color_text", label: __("Text", "sustainable-theme") },
		{ key: "color_text_muted", label: __("Muted text", "sustainable-theme") },
	];

	return (
		<div className="sw-palette">
			<div className="sw-palette__grid">
				{palettes.map((palette) => (
					<button
						key={palette.id}
						type="button"
						className={`sw-palette__card ${isSelected(palette.id) ? "sw-palette__card--selected" : ""}`}
						onClick={() => handlePaletteSelect(palette)}
					>
						<SwatchRow colors={palette.colors} />
						<span className="sw-palette__name">{palette.name}</span>
						<span className="sw-palette__desc">
							{palette.description}
						</span>
						{isSelected(palette.id) && (
							<span className="sw-palette__check">✓</span>
						)}
					</button>
				))}

				<button
					type="button"
					className={`sw-palette__card sw-palette__card--custom ${isSelected("custom") ? "sw-palette__card--selected" : ""}`}
					onClick={() => onChange({ palette_id: "custom" })}
				>
					<div className="sw-palette__custom-icon">
						<span className="dashicons dashicons-art" />
					</div>
					<span className="sw-palette__name">
						{__("Custom Palette", "sustainable-theme")}
					</span>
					<span className="sw-palette__desc">
						{__("Pick your own colors", "sustainable-theme")}
					</span>
					{isSelected("custom") && (
						<span className="sw-palette__check">✓</span>
					)}
				</button>
			</div>

			{settings.palette_id === "custom" && (
				<div className="sw-palette__custom-editor">
					<h4 className="sw-palette__custom-title">
						{__("Customize Colors", "sustainable-theme")}
					</h4>
					<div className="sw-palette__custom-grid">
						{customColors.map(({ key, label }) => (
							<div key={key} className="sw-palette__color-item">
								<button
									type="button"
									className="sw-palette__color-btn"
									onClick={() =>
										setCustomEditing(
											customEditing === key ? null : key,
										)
									}
								>
									<span
										className="sw-palette__color-preview"
										style={{
											backgroundColor: settings[key],
										}}
									/>
									<span className="sw-palette__color-label">
										{label}
									</span>
									<code className="sw-palette__color-hex">
										{settings[key]}
									</code>
								</button>
								{customEditing === key && (
									<div className="sw-palette__picker-popover">
										<ColorPicker
											color={settings[key]}
											onChange={(color) =>
												handleCustomColor(key, color)
											}
											enableAlpha={false}
										/>
									</div>
								)}
							</div>
						))}
					</div>
				</div>
			)}
		</div>
	);
}
