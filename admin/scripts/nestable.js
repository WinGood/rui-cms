$(document).ready(function() {
	$('#sort-box').nestable();
	$('#sort-box').prepend($('<div class="alert alert-success"></div>'));
	$('.alert').hide();

	$('.dd').bind('change', function(){
		$.ajax({
			url: '/admin/ajax/sortingWidgetPage',
			method: 'POST',
			data: {
				list:$(this).nestable('serialize'), 
				id_widget: $('input[name="id_widget"]').val()
			},
			success: function(resp)
			{
				$('.alert').text('Изменения сохранены').slideDown().delay(1200).slideUp();
			}
		});
	});

});