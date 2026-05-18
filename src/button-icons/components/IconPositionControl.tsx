/* eslint-disable @wordpress/no-unsafe-wp-apis */
import {
	__experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
	PanelRow,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import type { FC } from 'react';

type IconPositionControlProps = {
	isLeft: boolean;
	onChange: ( isLeft: boolean ) => void;
};

export const IconPositionControl: FC< IconPositionControlProps > = ( {
	isLeft,
	onChange,
} ) => {
	const handleChange = ( value?: string | number ) => {
		if ( undefined === value ) {
			return;
		}

		onChange( 'left' === String( value ) );
	};

	return (
		<PanelRow className="button-block-enhancements-control-wrapper">
			<ToggleGroupControl
				label={ __( 'Icon position', 'button_block_enhancements' ) }
				value={ isLeft ? 'left' : 'right' }
				onChange={ handleChange }
				isBlock
				className="button-block-enhancements-toggle-group-control"
			>
				<ToggleGroupControlOption
					value="left"
					label={ __( 'Left', 'button_block_enhancements' ) }
					className={ isLeft ? 'is-selected' : '' }
				/>
				<ToggleGroupControlOption
					value="right"
					label={ __( 'Right', 'button_block_enhancements' ) }
					className={ ! isLeft ? 'is-selected' : '' }
				/>
			</ToggleGroupControl>
		</PanelRow>
	);
};
