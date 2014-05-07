(function() {
 
 
    CKEDITOR.dialog.add( 'myplugin', function( editor )
    {
        var _dialog, _insertMode, _element, pluginName = 'myplugin';
 
        return {
            // название диалогового окна
            title : 'Title dialog',
 
            // минимальная ширина
            minWidth : 600,
 
            // минимальная высота
            minHeight : 300,
 
            // элементы
            contents : [
 
                {
                    // вкладка "tab1"
                    id : 'tab1',
                    label : 'Label',
                    title : 'Title',
                    expand : true,
                    padding : 0,
                    elements :
                    [
                        // текстовое поле <input type="text">
                        {
                            type : 'text',
                            id : 'title',
                            label : 'title label',
 
                            // что происходит при вызове setupContent
                            setup : function( element )
                            {
                                this.setValue( element.getAttribute( 'my_title' ) );
                            },
 
                            // что происходит при вызове commitContent
                            commit : function( element )
                            {
                                element.setAttribute( 'my_title', this.getValue() );
                            }
                        }
                    ]
                }
            ],
 
            // в окне будут 2 кнопки - Ok и Cancel
            buttons : [
                CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton
            ],
 
            // обработчик нажатия на кнопку Ok
            onOk : function() {
 
                var dialog = this,
                    image = _element;
 
                // если вставляем элемент первый раз, то добавим его в редактор
                if ( _insertMode )
                    editor.insertElement( image );
 
                // вынимаем контент из заполненной формы в атрибуты <img>
                // для каждого из элемента формы происходит то, что написано в его функции commit
                this.commitContent( image );
            },
 
            // срабатывает при открытии диалогового окна
            onShow : function() {
 
                // получаем элемент, который выбрали
                var sel = editor.getSelection(),
                    element = sel.getStartElement();
 
                _dialog = this;
 
                // если не <img> или нет атрибута 'myplugin', то создаем новый элемент
                if ( !element || element.getName() != 'img' || !element.getAttribute( pluginName ) )
                {
                    var attributes = {
                        // атрибут myplugin нужен для того, чтобы опознать наш элемент 
                        // среди других картинок в редакторе
                        myplugin: '1',
 
                        // в качестве картинки у нас выступает прозрачный пиксель
                        // внешний вид настраивается в CSS
                        src : '/ckeditor/images/spacer.gif'
                    };
 
                    element = editor.document.createElement( 'img', { attributes : attributes } );
                    element.setAttribute( 'class', pluginName );
 
                    // вставляем элемент первый раз
                    _insertMode = true;
                }
                else
                    // редактируем существующий элемент
                    _insertMode = false;
 
                _element = element;
 
                // заносим контент из атрибутов в форму
                this.setupContent( _element );
            }
 
        };
 
    });
})();