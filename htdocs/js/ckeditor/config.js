/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'ru';
	
	config.toolbar = 'Full';
	config.skin = 'moono-light';
	
	config.contentsCss = '/css/mycustom.css';
	
	config.filebrowserBrowseUrl      = '/js/ckeditor/kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = '/js/ckeditor/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = '/js/ckeditor/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl      = '/js/ckeditor/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = '/js/ckeditor/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = '/js/ckeditor/kcfinder/upload.php?type=flash';
	
	config.toolbar_toolbarLight =
	[
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar', 'Link','Unlink','Anchor', 'Maximize'] ,
		'/',
		['Styles','Format','Font','FontSize', 'Bold','Italic','Strike','NumberedList','BulletedList','Outdent','Indent','Blockquote', 'TextColor','BGColor'],
		
	];
	config.toolbar_toolbarVerySimple = 
	[
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt','Bold','Italic','Strike'],
	];
};
