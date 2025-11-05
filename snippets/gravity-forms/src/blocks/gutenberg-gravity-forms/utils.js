export function getColorCSSVar(attribute, customAttribute, varName) {
	if (attribute && !customAttribute) {
		return { [varName]: `var(--wp--preset--color--${attribute})` };
	}
	if (!attribute && customAttribute) {
		return { [varName]: customAttribute };
	}
	return {};
}
