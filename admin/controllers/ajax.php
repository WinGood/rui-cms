<?php
class Controllers_Ajax extends Controllers_Base
{
	public function ckupload()
	{
		// TODO Проверка на авторизацию(только админ)
		if(!empty($_FILES['upload']['name']))
		{
			$callback = 3;
			$file_name = $_FILES['upload']['name'];
			
			$getMime = explode('.', $file_name);
			$mime = end($getMime);
			
			$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
			if(!in_array($mime, $types))
			{
				$error = "Go Home";
				$http_path = '';
			}
			else
			{
				$file_name = substr_replace(sha1(microtime(true)), '', 12).'.'.$mime;	
								
				$file_name_tmp = $_FILES['upload']['tmp_name'];
				$full_path = CKUPLOAD_DIR.$file_name;

				if (move_uploaded_file($file_name_tmp, $full_path))
				{
					$http_path = '/'.$full_path;
					$error = '';
				}
				else
				{
					$error = $full_path;
					$http_path = '';
				}
			}
			echo "<script>window.parent.CKEDITOR.tools.callFunction($callback, \"".$http_path."\",\"".$error."\");</script>";
		}
	}

	public function strTranslit()
	{
		// TODO Проверка на авторизацию(только админ)
		if(isset($_POST['str']))
		{
			echo Url::translitEncode($_POST['str']);
		}
	}

	public function uploadImage()
	{
		// TODO Проверка на авторизацию(только админ)
		if($idImage = Model::factory('images')->uploadBase64($_POST['name'], $_POST['value']))
		{
			Model::factory('gallery')->addImage($_POST['id_gallery'], $idImage);

			die($_POST['name'] . ' - успешно загружено');
		}

		die($_POST['name'] . ' - ошибка загрузки');	
	}

	public function getGallery()
	{
		foreach (Model::factory('gallery')->all() as $key => $val)
		{   
		 
			$data[$key]['id_gallery'] = $val['id_gallery'];
			$data[$key]['title'] = $val['title'];	
		}

		echo json_encode($data);  
	}

	public function sortingWidgetPage()
	{
		$idWidget = $_POST['id_widget'];
		$pages    = $_POST['list'];
		$obj      = array();

		for($i = 0; $i < count($pages); $i++)
		{
			$idPage = (int) $pages[$i]['id'];

			$obj['num_sort']  = $i;
			$obj['id_parent'] = 0;

			if(!empty($pages[$i]['children']))
			{
				DB::update('widgets_sort')
					->set($obj)
					->where('id_widget', '=', $idWidget)
					->where('id_page', '=', $idPage)
					->execute();

				$this->sortingWidgetPageChild($pages[$i]['children'], $pages[$i]['id'], $idWidget);
			}
			else
			{
				DB::update('widgets_sort')
					->set($obj)
					->where('id_widget', '=', $idWidget)
					->where('id_page', '=', $idPage)
					->execute();
			}
		}
		
		echo 'true';
	}

	private function sortingWidgetPageChild($data, $parent, $idWidget)
	{
		for($j = 0; $j < count($data); $j++)
		{
			$idPage = (int) $data[$j]['id'];

			$child['id_parent'] = $parent;
			$child['num_sort']  = $j;

			DB::update('widgets_sort')
				->set($child)
				->where('id_widget', '=', $idWidget)
				->where('id_page', '=', $idPage)
				->execute();

			if(!empty($data[$j]['children']))
				$this->sortingWidgetPageChild($data[$j]['children'], $data[$j]['id'], $idWidget);
		}
	}
}