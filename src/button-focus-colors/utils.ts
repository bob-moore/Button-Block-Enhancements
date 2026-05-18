type FocusColorAttributes = {
	bmdFocusBackgroundColor?: string;
	bmdFocusColor?: string;
	className?: string;
	style?: Record< string, string >;
};

const FOCUS_COLOR_CLASS_NAMES = [
	'has-bmd-focus-color',
	'has-bmd-focus-background-color',
	'has-bmd-focus-colors',
];

export const getClassNameWithFocusColors = (
	className = '',
	attributes: FocusColorAttributes
) => {
	const classNames = className.split( /\s+/ ).filter( ( value ) => {
		return value && ! FOCUS_COLOR_CLASS_NAMES.includes( value );
	} );

	if ( attributes.bmdFocusColor ) {
		classNames.push( 'has-bmd-focus-color' );
	}

	if ( attributes.bmdFocusBackgroundColor ) {
		classNames.push( 'has-bmd-focus-background-color' );
	}

	return classNames.join( ' ' );
};

export const getFocusColorStyle = ( attributes: FocusColorAttributes ) => {
	return {
		...( attributes.style ?? {} ),
		...( attributes.bmdFocusColor
			? { '--bmd-button-focus-color': attributes.bmdFocusColor }
			: {} ),
		...( attributes.bmdFocusBackgroundColor
			? {
					'--bmd-button-focus-background-color':
						attributes.bmdFocusBackgroundColor,
			  }
			: {} ),
	};
};
