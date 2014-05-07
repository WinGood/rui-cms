<?php

/*
 * Ядро системы init систему, получаем настройки
 * устанавливаем необходимые константы 
 */

class RUI
{
	private static $_instance;
	private static $_registry = array();

	private function __construct()
	{
		define('SITE', 'http://'.$_SERVER['SERVER_NAME'].Url::getCutSection());
	}

	private function __clone(){}

	public static function getInstance()
	{
		if(empty(self::$_instance))
			self::$_instance = new self;
		return self::$_instance;	
	}

	public static function init()
	{
		self::getInstance();

		$res = DB::select()->from('preference')->execute();
		$options = array();
		
		// Получаем настройки сайта, заносим их в registry
		if(!empty($res))
		{
			foreach($res as $item)
			{
				self::$_registry[$item['name']] = $item['value'];
			}
		}

		self::setTemplate(self::$_registry['CURRENT_TPL']);

		include CORE_DIR.'views/functions.php';
		
		if(file_exists(PATH_TEMPLATE.'/functions.php'))
			include PATH_TEMPLATE.'/functions.php';
	}
	
	/*
	 * Определяет шаблон
	 */

	private static function setTemplate($name = 'default')
	{
		$pathTemplate = TPL_DIR.$name;
		define('PATH_TEMPLATE', $pathTemplate);
		set_include_path(PATH_TEMPLATE."/".PATH_SEPARATOR.get_include_path());
	}
	
	/*
	 * Формирует meta-теги
	 */

	public static function getMeta()
	{
		$metaTitle       = self::get('metaTitle');
		$metaKeywords    = self::get('metaKeywords');
		$metaDescription = self::get('metaDescription');
		$title           = $metaTitle ? $metaTitle : self::get('title');

		$meta = '
		<meta charset="UTF-8">
		<title>'.$title.'</title>
		<meta name="keywords" content="'.$metaKeywords.'" />
		<meta name="description" content="'.$metaDescription.'" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';

		$meta .= self::get('userMeta');

		return $meta;
	}

	public static function get($name)
	{
		if(isset(self::$_registry[$name]))
			return self::$_registry[$name];
	}

	public static function set($name, $val)
	{
		self::$_registry[$name] = $val;
	}
	
	/*
	 * Вызывается в шаблоне(views)
	 * Добавляем в registry найденные данные, self::getMeta() - подставляем их
	 */

	public static function seoMeta($data)
	{
		if(is_array($data))
		{
			!empty($data['title']) ? self::set('title', $data['title']) : self::set('title', null);
			!empty($data['metaTitle']) ? self::set('metaTitle', $data['metaTitle']) : self::set('metaTitle', null);
			!empty($data['metaKeywords']) ? self::set('metaKeywords', $data['metaKeywords']) : self::set('metaKeywords', null);
			!empty($data['metaDescription']) ? self::set('metaDescription', $data['metaDescription']) : self::set('metaDescription', null);
		}
	}
	
	/*
	 * Пользовательские meta данные, обычно скрипты, стили
	 */

	public static function addMeta($data)
	{
		self::set('userMeta', self::get('userMeta')."\n".$data);
	}

	public static function show404()
	{
		if(file_exists(PATH_TEMPLATE.'/page404.php'))
			include(PATH_TEMPLATE.'/page404.php');
		else
			include(CORE_DIR.'page404.php');
		die();
	}
	
	/*
	 * Редактируемая область, добавлет data необходимые для работы front-end'a
	 */

	public static function frontContent($type, $one)
	{
		$res = '';
		if(User::isAdmin())
		{
			$pk = "id_$type";
			$res = "data-widget-toggle=\"$type\" data-widget-node=\"{$one[$pk]}\"";
		}
		
		return $res;
	}
	
	/*
	 * Редактируемое поле
	 */

	public static function frontField($key, $type)
	{
		$res = '';
		
		if(User::isAdmin())
			$res = "data-change-key=\"$key\" data-replace=\"$type\"";
		
		return $res;
	}
	
	/*
	 * Редактируемая область в sidebar, добавлет data необходимые для работы front-end'a
	 */
	
	public static function frontWidgetSpace($idMenu)
	{
		$res = '';
		if(User::isAdmin())
		{
			$res = "data-widget-space=\"$idMenu\"";
		}
		
		return $res;
	}
	
	/*
	 * Виджет в sidebar добавлет сортировку
	 */

	public static function frontWidgetBlock($id)
	{
		$res = '';
		if(User::isAdmin())
		{
			$res = "data-widget-sortable=\"$id\"";
		}
		
		return $res;
	}
}