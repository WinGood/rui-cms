<?php
defined('SECURE') or exit('Access denied');
class Controllers_Widget extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		$this->model = Model::factory('widgets');
	}

	public function gallery()
	{
		echo View::template('widget/gallery.php', array(
			'img' => Model::factory('gallery')->getImages($this->getParam(0))
		));
	}

	public function slider()
	{
		echo 'slider';
	}

	public function nav()
	{
		if($this->getParam(0) == 'hor')
		{
			$id = $this->getParam(2);
			$view = 'nav-horizontal.php';
		}
		else
		{
			$id = $this->getParam(1);
			$view = 'nav.php';
		}

		$widget = $this->model->getWidget($id);

		echo View::template('widget/'.$view, array(
			'pages' => $this->model->getThree($id),
			'title' => $widget['name_in_menu'],
			'id'	=> $widget['id_widget'] 
		));
	}

	public function search()
	{
		$widget = $this->model->getWidgetByPath('search');
		
		echo View::template('widget/search.php', array(
			'title' => $widget['name_in_menu'],
			'id'	=> $widget['id_widget'] 
		));
	}
}