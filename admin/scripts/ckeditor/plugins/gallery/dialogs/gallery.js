var winAdd = '';

function checkWinAdd()
{
	if(winAdd)
	{
		if(!winAdd || winAdd.closed)
		{
			winAdd = false;
		}
	}
}

CKEDITOR.dialog.add('gallery', function(editor) {
		$.ajax({
			type: 'POST',
			url: '/admin/ajax/getGallery',
			success: function(msg){ 
				CKEDITOR.arrGallery = msg; 
				arr = JSON.parse(CKEDITOR.arrGallery);
				arr2 =[];
				for (var i in arr)
				{
					arr2.push([arr[i]['title'],arr[i]['id_gallery']]);
				}
			},
			async: false     
        });

	return {
		title : 'Вставить галерею',
		minWidth : 400,
		minHeight : 200,
		contents :
			[
				{
					id : 'tab1',
					label : 'Gallerys',
					elements :
					[       
						{
						type: 'hbox',
					    widths: [ '50%', '50%' ],
					    children: [{       
								type : 'select',
								id : 'gallery',
								default: '1',
								label : 'Выберите галерею',
								width: '123px',
								items : arr2,
							},
							{       
								type : 'button',
								id : 'new_gal',
								label : 'Создать галерею',
								onClick: function()
								{
								    CKEDITOR.dialog.getCurrent().hide();
								    winAdd = window.open('/admin/gallery/add', 'new', 'width=1000,height=600,resizable=yes,scrollbars=no,status=yes');
								    window.setInterval('checkWinAdd()', 3000);
								}						
							}]
						},
						{       
							type : 'select',
							id : 'player',
							label : 'Как отображать',
							items: [ ['Галерея', 'lightbox'], ['Слайдер', 'slider'] ],
    						default: 'lightbox',
						}
					]
				}
			],
		

		onOk: function () {
			var gallery_id = this.getContentElement('tab1', 'gallery').getValue();
			var player_type = this.getContentElement('tab1', 'player').getValue();
			var element = this.getContentElement('tab1', 'gallery').getInputElement().$;
			var gallery_title = element.options[element.selectedIndex].text;
			var widget = editor.document.createElement('widget');
			widget.setAttribute('title', gallery_title);
			widget.setAttribute('widget-type', player_type);
			
			if(player_type=='lightbox'){
				widget.setText('[[--widget/gallery/' + gallery_id + '--]]');
				widget = editor.createFakeElement(widget, "cke_gallery", "widget", !0);
			}
			if(player_type=='slider'){
				widget.setText('[[--widget/slider/' + gallery_id + '--]]');
				widget = editor.createFakeElement(widget, "cke_slider", "widget", !0);
			}
			widget.$.title = gallery_title;
			editor.insertElement(widget);
        }
  };
});
