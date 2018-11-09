/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here. For example:
	config.language = 'fr';
	config.uiColor = '#AADC6E';
	config.toolbarGroups = [
		{name: 'styles', groups: ['styles']},
		'/',
		{name: 'document', groups: ['mode', 'document', 'doctools']},
		{name: 'clipboard', groups: ['clipboard', 'undo']},
		{name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
		{name: 'forms', groups: ['forms']},
		{name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
		{name: 'colors', groups: ['colors']},
		{name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
		{name: 'links', groups: ['links']},
		{name: 'insert', groups: ['insert']},
		{name: 'tools', groups: ['tools']},
		{name: 'others', groups: ['others']},
		{name: 'about', groups: ['about']}
	];
	
	config.removeButtons = 'Print,Preview,NewPage,Source,Save,Templates,PasteText,PasteFromWord,Replace,Form,Checkbox,Radio,Textarea,TextField,Select,Button,ImageButton,HiddenField,CopyFormatting,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,PageBreak,Iframe,ShowBlocks,About';
};
