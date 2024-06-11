/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E'; 
	config.font_names = " MLW TTRevathi , MLW-TTRevathi ; Malayalam Thunchan , thunchan-malayalam;"+config.font_names
	config.toolbarGroups = [
		// { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		// { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		// { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		// { name: 'forms', groups: [ 'forms' ] },
		// '/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		// { name: 'links', groups: [ 'links' ] },
		// { name: 'insert', groups: [ 'insert' ] },
		// '/',
		// { name: 'styles', groups: [ 'styles' ] },
		// { name: 'colors', groups: [ 'colors' ] },
		// { name: 'tools', groups: [ 'tools' ] },
		// { name: 'others', groups: [ 'others' ] },
		// { name: 'about', groups: [ 'about' ] }
	];
	config.allowedContent = true;
	config.removeButtons = 'Save,NewPage,ExportPdf,Preview,Print,Templates,PasteText,PasteFromWord,Cut,SelectAll,BidiLtr,BidiRtl,Language,Image,Smiley,SpecialChar,PageBreak,ShowBlocks,About';
};
