$(document).ready(function() {
	$('#inputUrl').bind('click', function(){
		var title = $('#inputTitle').val();
		if(title != '')
		{
			$.ajax({
				url: '/admin/ajax/strTranslit',
				method: 'POST',
				data: {str:title},
				success: function(resp)
				{
					$('#inputUrl').val(resp);
				}
			});
		}
	});

	$('.delete-btn').bind('click', function(){
		if(!confirm('Вы действительно хотите удалить сущность?'))
		{
			return false;
		}
	});

	$('#hide-nav').bind('click', function(){
		$('.content-page div.span3').hide();
		$('.content-page div.span8').removeClass('span8');
		return false;
	});

	$('#inputEl').change(function () {
		var value = $(this).val();
		selectChild(value);
	});
});

function selectChild(parent, child)
{
	$('#inputEl option').each(function(){
		if($(this).data('parent') == parent)
		{
			$(this).attr('selected', 'selected');
			selectChild($(this).val(), $(this).data('child'));
		}
	});
}