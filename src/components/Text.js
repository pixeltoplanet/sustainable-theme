import { __experimentalText as WordPressText } from "@wordpress/components";

const Text = ({ children, hasMaxWidth }) => {
	return (
		<WordPressText
			isBlock
			size="16px"
			style={{ maxWidth: hasMaxWidth ? "600px" : "none" }}
		>
			{children}
		</WordPressText>
	);
};
export default Text;
