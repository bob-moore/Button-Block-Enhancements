import { addFilter } from '@wordpress/hooks';

import {
	addButtonFocusColorAttributes,
	ButtonFocusColorBlockList,
	ButtonFocusColorEdit,
} from './button-focus-colors';
import {
	addButtonIconAttributes,
	ButtonIconBlockList,
	ButtonIconEdit,
} from './button-icons';

addFilter(
	'blocks.registerBlockType',
	'button-block-enhancements/add-button-icon-attributes',
	addButtonIconAttributes
);

addFilter(
	'editor.BlockEdit',
	'button-block-enhancements/add-button-icon-inspector-controls',
	ButtonIconEdit
);

addFilter(
	'editor.BlockListBlock',
	'button-block-enhancements/add-button-icon-preview-classes',
	ButtonIconBlockList
);

addFilter(
	'blocks.registerBlockType',
	'button-block-enhancements/add-button-focus-color-attributes',
	addButtonFocusColorAttributes
);

addFilter(
	'editor.BlockEdit',
	'button-block-enhancements/add-button-focus-color-controls',
	ButtonFocusColorEdit
);

addFilter(
	'editor.BlockListBlock',
	'button-block-enhancements/add-button-focus-color-preview',
	ButtonFocusColorBlockList
);
