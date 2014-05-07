$(document).ready(function() {
	if($('#replace').length > 0)
		CKEDITOR.replace('replace', {
			filebrowserUploadUrl : '/admin/ajax/ckupload',
			extraPlugins: 'gallery'
	});
});