<?php

/*
 * Обрабатывает ajax запросы с фронтенда
 */

class Controllers_Frontedit extends Controllers_Base
{
	public function save()
	{
		$model = Model::factory('pages');
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
		if($this->isPost())
		{
			$page = Model::factory('pages')->get($_POST['id']);
			$data = $page['content'];
			echo $data;	
		}
	}

	public function sortingWidgets()
	{
		if(!empty($_POST['list']))
		{
			DB::delete('menu_widget')->where('id_menu', '=', $_POST['menu'])->execute();
			$widgets = explode(',', $_POST['list']);

			for($i = 0; $i < count($widgets); $i++)
			{
				$data = array(
					'id_menu'   => $_POST['menu'],
					'id_widget' => $widgets[$i],
					'num_sort'  => $i
				);
				
				DB::insert('menu_widget', $data)->execute();
			}
			
			echo true;
		}
	}
}