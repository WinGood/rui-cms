$(document).ready(function() {
	$('#gallery_sortable').sortable();
	
	$('.form-sorting button').click(function(e){

		var pages = [];
		
		$('.sorting li').each(function(){
			pages.push($(this).data('id-page'));
		});
		
		$('.form-sorting input[name=pages]').val(pages.toString());
		$('.form-sorting').submit();

		return false;
	});
});