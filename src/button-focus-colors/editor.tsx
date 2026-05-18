import { createHigherOrderComponent } from '@wordpress/compose';

import { getClassNameWithFocusColors, getFocusColorStyle } from './utils';

type BlockListBlockProps = {
	attributes?: {
		bmdFocusBackgroundColor?: string;
		bmdFocusColor?: string;
		className?: string;
		style?: Record< string, string >;
	};
	className?: string;
	name?: string;
	wrapperProps?: Record< string, unknown >;
};

export const BlockListBlock = createHigherOrderComponent(
	( BlockListBlockComponent ) => {
		return ( props: BlockListBlockProps ) => {
			if ( 'core/button' !== props.name ) {
				return <BlockListBlockComponent { ...props } />;
			}

			const attributes = props.attributes ?? {};
			const className = getClassNameWithFocusColors(
				( props.wrapperProps?.className as string ) ?? '',
				attributes
			);
			const style = getFocusColorStyle( attributes );

			return (
				<BlockListBlockComponent
					{ ...props }
					wrapperProps={ {
						...( props.wrapperProps ?? {} ),
						className,
						style: {
							...( ( props.wrapperProps?.style as Record<
								string,
								string
							> ) ?? {} ),
							...style,
						},
					} }
				/>
			);
		};
	},
	'withButtonFocusColorEditorPreview'
);
