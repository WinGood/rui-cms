$(document).ready(function() {
	var widgets = [];

	$('*[data-widget-toggle]').each(function(){
		var widget = new widgetEdit(this);
	});
});

function widgetEdit(widget)
{
	this.widget = $(widget);
	var id      = this.widget.data('widget-node');
	var that    = this;
	var isEdit  = true;
	var chgKey  = '';

	this.widget.find('*[data-change-key]').wrap('<div class="widget-node"></div>');

	// Получаем текущий margin
	var marginBox = $('.widget-node *:nth-child(1)').css('margin');
	
	$('.widget-node *:nth-child(1)').css({
		margin: '0'
	});

	$('.widget-node').css({
		border: '1px dashed red',
		position: 'relative',
		marginBottom: '10px'
	});

	// Кнопка редактирования
	$('.widget-node').append($('<a class="front-edit-btn" href="javascript:void(0);"></a>'));

	//

	this.widget.append($('<div class="widget-edit">Сохранить</div>').hide());
	this.widget.append($('<div class="widget-alert"></div>').hide());

	$('.widget-edit').css({
		background: '#0088cc',
		position: 'fixed',
		top: '0',
		right: '10px',
		cursor: 'pointer',
		'z-index': 10000,
		'font-size': '14px',
		'padding': '11px 18px',
		color: 'white'
	});

	$('.widget-alert').css({
		background: '#00cc66',
		position: 'fixed',
		bottom: '0',
		right: '10px',
		cursor: 'pointer',
		'z-index': 10000,
		'font-size': '14px',
		'padding': '11px 18px',
		color: 'white'
	});

	this.widget.find('.widget-node .front-edit-btn').click(function(e){
		that.replaceEl($(this).closest('.widget-node').find('*[data-change-key]'));
		return false;
	});

	this.replaceEl = function(el)
	{
		if(!isEdit)
			return false;

		isEdit = false;
		el.hide();

		el.after(that.getReplaceEl(el));

		$('.widget-edit').slideDown();

		if(el.next().attr('id') == 'replaceFront')
		{
			CKEDITOR.replace('replaceFront',
			{
				filebrowserUploadUrl : '/admin/ajax/ckupload',
				extraPlugins: 'gallery',
				height: '500px'
			});

			$.ajax({
				type: 'POST',
				url: '/frontedit/getPage',
				data: {id: id},
				success: function(data)
				{
					el.next().val(data);
				},
				async: false
			});
		}
		else
		{
			el.next().val(el.html());
		}

		chgKey = el.data('change-key');

		that.widget.find('.widget-edit').click(function(e){
			that.save(el);
		});
	}

	this.getReplaceEl = function(el)
	{
		var type = el.data('replace');
		var res = '';

		switch(type)
		{
			case 'input':
				res = '<input type="text" style="height:35px;">';
			break;
			case 'ck':
				res = '<textarea id="replaceFront"></textarea>';
			break;
			default:
				res = '<input type="text" style="height:35px;">';
		}

		return res;
	}

	this.getReplaceVal = function(el)
	{
		var type = el.data('replace');
		var res = '';

		switch(type)
		{
			case 'input':
				res = el.next().val();
			break;
			case 'ck':
				res = CKEDITOR.instances.replaceFront.getData();
			break;
			default:
				res = el.next().val();
		}

		return res;
	}

	this.save = function(el)
	{
		var val   = that.getReplaceVal(el);
		var obj   = {id: id, is_show: 1, act: action};
		var name  = chgKey;
		obj[name] = val;

		console.log(obj);

		$.post('/frontedit/save', obj, function(data){
			if(data.errors.length > 0)
			{
				alert(data.errors);
				el.next().val(el.html());
			}
			else
			{
				isEdit = true;
				var text = data.res[name];
				el.html(text).show().next().remove();
				$('#cke_replaceFront').remove();
				$('.widget-edit').slideUp();
				$('.widget-alert').text('Поле ' + name + ' обновленно!').slideDown().delay(1200).slideUp();
			}
		}, 'json');
	}
}