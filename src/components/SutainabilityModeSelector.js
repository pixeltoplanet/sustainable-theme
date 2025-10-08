import { __ } from "@wordpress/i18n";
import {
	RadioControl,
	__experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
} from "@wordpress/components";

export default function SutainabilityModeSelector({
	value = "base",
	onChange,
}) {
	const handleChange = (selectedValue) => {
		if (onChange) {
			onChange(selectedValue);
		}
	};

	return (
		<RadioControl
			onChange={handleChange}
			className="sustainable-theme-radio-group-vertical"
			selected={value}
			options={[
				{
					label: __("Just sustainable", "sustainable-theme"),
					description: __(
						"The basics to make your website more sustainable.",
						"sustainable-theme",
					),
					value: "base",
				},
				{
					label: __("Super sustainable", "sustainable-theme"),
					description: __(
						"The most sustainable website possible.",
						"sustainable-theme",
					),
					value: "super",
				},
				{
					label: __("Custom mode", "sustainable-theme"),
					description: __(
						"Customize your sustainability settings.",
						"sustainable-theme",
					),
					value: "custom",
				},
			]}
		/>
	);
}
