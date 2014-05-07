$(document).ready(function() {
	$('.sorting').sortable();
	
	$('.form-sorting button').click(function(e){

		var pages = [];
		
		$('.sorting li').each(function(){
			pages.push($(this).data('id-page'));
		});
		
		$('.form-sorting input[name=pages]').val(pages.toString());
		$('.form-sorting').submit();

		return false;
	});

	$('.form-menu button').click(function(e){

		var widgets = [];
		
		$('.box-content .portlet').each(function(){
			widgets.push($(this).data('widget-id'));
		});
		
		$('input[name=widgets]').val(widgets.toString());
		$('.form-menu').submit();

		return false;
	});

	$( ".column" ).sortable({
		connectWith: ".column",
		handle: ".portlet-header",
		cancel: ".portlet-toggle",
		placeholder: "portlet-placeholder ui-corner-all"
	});

	$('.portlet-content').hide();
	 
	$( ".portlet" )
	.addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
	.find( ".portlet-header" )
	.addClass( "ui-widget-header ui-corner-all" )
	.prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
	 
	 $( ".portlet-toggle" ).click(function() {
	 	var icon = $( this );
	 	icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
	 	icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
	 });

});