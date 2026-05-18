type BlockSettings = {
	attributes?: Record< string, unknown >;
};

export const addCustomAttributes = (
	settings: BlockSettings,
	name: string
) => {
	if ( 'core/button' !== name ) {
		return settings;
	}

	return {
		...settings,
		attributes: {
			...settings.attributes,
			bmdFocusColor: {
				type: 'string',
				default: '',
			},
			bmdFocusBackgroundColor: {
				type: 'string',
				default: '',
			},
		},
	};
};
