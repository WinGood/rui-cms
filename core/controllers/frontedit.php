<?php

/*
 * Обрабатывает ajax запросы с фронтенда
 */

class Controllers_Frontedit extends Controllers_Base
{
	public function save()
	{
		$model = new Models_Pages;
		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'title'   => 'required',
				'content' => 'required'
			)))
			{
				$model->frontEdit($_POST['id'], $_POST);

				$page = $model->get($_POST['id']);
				$data['res'] = $this->parseWidget($page);
			}
			
			$data['errors'] = $err;

			echo json_encode($data);	
		}
	}

	public function getPage()
	{
		$model = new Models_Pages;
		if($this->isPost())
		{
			$page = $model->get($_POST['id']);
			$data = $page['content'];
			echo $data;	
		}
	}

	public function sortingWidgets()
	{
		if(!empty($_POST['list']))
		{
			$where = "id_menu = $_POST[menu]";
			DB::getInstance()->delete('menu_widget', $where);

			$widgets = explode(',', $_POST['list']);
			$obj = array('id_menu' => $_POST['menu']);

			for($i = 0; $i < count($widgets); $i++)
			{
				$obj['id_widget']  = $widgets[$i];
				$obj['num_sort'] = $i;
				DB::getInstance()->insert('menu_widget', $obj);
			}
			
			echo true;
		}
	}
}