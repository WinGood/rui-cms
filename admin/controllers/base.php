<?php
abstract class Controllers_Base
{
	protected $title;
	protected $content;
	protected $keywords;		
	protected $description;
	protected $rightNav;
	protected $scripts;
	protected $styles;

	public function __construct()
	{
		if(!User::isAdmin())
			Url::redirect('/');

		$this->scripts = array('script', 'ckeditor/ckeditor', 'ckeditor/ck_init');
		$this->styles  = array('style');
		
		include(ADMIN_DIR.'functions.php');
	}

	protected function generate()
	{
		$vars = array(
			'title'    => $this->title, 
			'content'  => $this->content,
			'rightNav' => $this->rightNav,
			'scripts'  => $this->scripts,
			'styles'   => $this->styles
		);

		$layout = View::getLayout();
		$page   = View::template('layout/'.$layout, $vars);			
		echo $page;
	}

	protected function setRightNav($data)
	{
		$link = array();
		foreach($data as $k => $v)
		{
			$link['admin/'.$k] = $v;
		}
		$this->rightNav = $link;
	}

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