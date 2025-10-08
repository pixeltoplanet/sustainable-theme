export default function Heading({ children, level = 2 }) {
	const HeadingTag = `h${level}`;

	return (
		<HeadingTag className="sustainable-theme-heading">{children}</HeadingTag>
	);
}
