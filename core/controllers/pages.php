<?php

/*
 * Контроллер статических страниц
 */

class Controllers_Pages extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = new Models_Pages;
	}

	public function index()
	{
		Url::redirect('/main');
	}

	public function view($params)
	{
		$url = $this->getUrl();
		if($url == 'home')
			Url::redirect('/');

		$page = $this->model->getPageUrl($url);
		if(!$page) RUI::show404();

		// Если странице задан индивидуальный шаблон
		if($page['id_tpl'])
		{
			$tpl = $this->model->getTpl($page['id_page']);
			View::setLayout('pages/'.$tpl['path']);
		}

		if($page['id_menu'] != 0)
		{
			// Если на странице задано индивидуальное меню
			$this->leftMenu = $this->menus->getMenuById($page['id_menu']);
		}

		$this->content = View::template('pages/view.php', array(
			'data'        => $page,
			'breadcrumbs' => Breadcrumbs::getBreadcrumbs()
		));

		$this->generate();
	}
}