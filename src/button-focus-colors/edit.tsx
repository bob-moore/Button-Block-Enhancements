import { createHigherOrderComponent } from '@wordpress/compose';
import {
	InspectorControls,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

import type { BlockEditProps } from '../types';

type ButtonFocusColorAttributes = {
	bmdFocusBackgroundColor: string;
	bmdFocusColor: string;
	className?: string;
};

type ButtonBlockEditProps = BlockEditProps< ButtonFocusColorAttributes >;

export const Edit = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props: ButtonBlockEditProps ) => {
		const { attributes, isSelected, name, setAttributes } = props;

		if ( 'core/button' !== name ) {
			return <BlockEdit { ...props } />;
		}

		const colorGradientSettings = useMultipleOriginColorsAndGradients();
		const { bmdFocusBackgroundColor, bmdFocusColor } = attributes;
		const hasFocusColors = Boolean(
			bmdFocusColor || bmdFocusBackgroundColor
		);
		const handleFocusColorChange = ( value?: string ) => {
			setAttributes( {
				bmdFocusColor: value ?? '',
			} );
		};
		const handleFocusBackgroundColorChange = ( value?: string ) => {
			setAttributes( {
				bmdFocusBackgroundColor: value ?? '',
			} );
		};

		return (
			<>
				<BlockEdit { ...props } />
				{ isSelected && (
					<InspectorControls group="color">
						<ColorGradientSettingsDropdown
							settings={ [
								{
									label: __(
										'Text: Focus',
										'button_block_enhancements'
									),
									colorValue: bmdFocusColor,
									onColorChange: handleFocusColorChange,
									clearable: true,
									resetAllFilter: () => ( {
										bmdFocusColor: '',
									} ),
								},
								{
									label: __(
										'Background: Focus',
										'button_block_enhancements'
									),
									colorValue: bmdFocusBackgroundColor,
									onColorChange:
										handleFocusBackgroundColorChange,
									clearable: true,
									resetAllFilter: () => ( {
										bmdFocusBackgroundColor: '',
									} ),
								},
							] }
							panelId={ props.clientId }
							hasColorsOrGradients={ hasFocusColors }
							disableCustomColors={ false }
							enableAlpha
							__experimentalIsRenderedInSidebar
							{ ...colorGradientSettings }
						/>
					</InspectorControls>
				) }
			</>
		);
	};
}, 'withButtonFocusColorControls' );
