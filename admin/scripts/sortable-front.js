$(document).ready(function() {
	$('*[data-widget-space]').each(function(){
		var idMenu = $(this).data('widget-space');
		
		$(this).find('*[data-widget-sortable]').css({
			border: '1px dashed red',
			position: 'relative',
			cursor: 'pointer'
		});

		$(this).sortable({
			update: function(event, ui)
			{
				var widgets = [];
				$('*[data-widget-sortable]').each(function(){
					widgets.push($(this).data('widget-sortable'));
				});

				$.ajax({
					url: '/frontedit/sortingWidgets',
					method: 'POST',
					data: {list: widgets.toString(), menu: idMenu},
					dataType: 'json',
					success: function(resp)
					{
						console.log(resp);
					}
				})
			}
		});
	});
});