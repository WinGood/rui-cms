<?php

/*
 * Контроллер гл. страницы сайта
 */

class Controllers_Main extends Controllers_Base
{
	public function index()
	{
		$data = Model::factory('pages')->getPageUrl('home');
		
		// if($data['id_menu'] != 0)
		// {
		// 	$this->leftMenu = $this->menus->getMenuById($data['id_menu']);
		// }

		$this->content = View::template('main.php', array(
			'data'        => $data,
			'breadcrumbs' => Breadcrumbs::getBreadcrumbs($data['title'])
		));

		$this->generate();
	}
}