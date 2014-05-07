<?php

/**
 * Базовый контроллер для публичной части сайта
 */

abstract class Controllers_Base
{
	private $title;
	protected $content;
	protected $keywords;		
	protected $description;
	protected $topMenu;
	protected $leftMenu;
	protected $menus;

	public function __construct()
	{
		$this->menus = new Models_Menus;

		$this->topMenu  = $this->menus->getMenuByCode('top');
		$this->leftMenu = $this->menus->getMenuByCode('left');
	}
	
	/*
	 * Генерируем "собираем" страницу и выводим пользователю
	 */
	
	protected function generate()
	{	
		$vars = array(
			'content'  => $this->content,
			'topMenu'  => $this->topMenu,
			'leftMenu' => $this->leftMenu
		);

		if(User::isAdmin())
		{
			include(ADMIN_DIR.'admin-bar.php');
			// Подключаем скрипты для работы front-end'a
			RUI::addMeta(
				'<script src="/'.ADMIN_DIR.'scripts/ckeditor/ckeditor.js"></script>'.
				'<script src="/'.ADMIN_DIR.'scripts/ckeditor/ck_init.js"></script>'.
				'<script src="/'.ADMIN_DIR.'scripts/jq-ui.js"></script>'.
				'<script src="/'.ADMIN_DIR.'scripts/sortable-front.js"></script>'.
				'<script src="/'.ADMIN_DIR.'scripts/front-end.js'.'"></script>'
			);
		}

		$layout = View::getLayout();
		$page   = $this->parseWidget(View::template('layout/'.$layout, $vars));	

		echo $page;
	}
	
	/*
	 * Ищем виджеты согласно регулярки например: widget/gallery/1
	 * обращаемся по uri получаем html
	 */

	protected function parseWidget($str)
	{
		// Что бы нельзя было обратиться напрямую через адр. строку
		define('SECURE', TRUE);

		return preg_replace_callback(
			WIDGETS_REPLACE_PATTERN,
			function ($matches)
			{
				return Controllers_Base::request($matches[2]);
			},
			$str
		);
	}
	
	/*
	 * Обращаемся по uri, находим контроллер и экшен выпоняем их
	 * для виджетов контроллер widget/action/params
	 */

	protected function request($uri)
	{
		ob_start();
		
		$rout = new Route();
		$rout->run($uri);

		return ob_get_clean();
	}
	
	/*
	 * Установка значения тега title
	 */

	protected function setTitle($val)
	{
		$this->title .= $val;
		RUI::set('title', $this->title);
	}

	/*
	 * TODO: обезопасить параметры, написать нормальный класс request
	 */
	
	protected function getParam($num)
	{
		$res = '';
		$uri = RUI::get('URI_PARAMS');

		if(is_integer($num))
		{
			if(isset($uri[$num]))
				$res = $uri[$num];
		}
		else
		{
			if(!empty($_GET) AND isset($_GET[$num]))
				$res = $_GET[$num];
		}

		return $res;
	}

	protected function getUrl()
	{
		return implode('/', RUI::get('URI_PARAMS'));
	}

	protected function isGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	protected function isPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	protected function isNum($val)
	{
		return (int) $val;
	}
}