<?php
class Controllers_Gallery extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = Model::factory('gallery');

		$nav = array(
			'gallery'     => 'Фотогалерея',
			'gallery/add' => 'Добавить галерею'
		);

		$this->setRightNav($nav);
	}

	public function index()
	{
		$this->title = 'Фотогалерея';
		
		$this->content = View::template('gallery/index.php', array(
			'gallery' => $this->model->all()
		));

		$this->generate();
	}

	public function images()
	{
		$this->title     = 'Изображения';
		$this->scripts[] = 'jq-ui';
		$this->scripts[] = 'image-sort';

		$id = $this->getParam(0);
		
		$data['gallery'] = $this->model->get($id);
		$data['images']  = $this->model->getImages($id);

		$this->content = View::template('gallery/images.php', $data);
		$this->generate();
	}

	public function upload()
	{
		// Проверка на существ. галереи
		$id = $this->getParam(0);
		if((empty($id)) OR !$gallery = $this->model->get($id))
			Url::redirect('/admin/gallery');

		$this->scripts[] = 'jq-ui';
		$this->scripts[] = 'image-upload';

		$this->title = 'Загрузка изображений';
		$data = array();
		$data['fields'] = $gallery;

		$this->content = View::template('gallery/upload.php', $data);
		$this->generate();
	}

	public function add()
	{
		$this->title = 'Добавление галереи';
		$data = array();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'title' => 'required',
				'code'  => 'required'
			)))
			{
				if($res = $this->model->add($_POST))
				{
					Url::setFlash('success', 'Галерея успешно создана!', 'success');
					Url::redirect('/admin/gallery');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
		}

		$this->content = View::template('gallery/add.php', $data);
		$this->generate();
	}

	public function edit()
	{
		$id = $this->getParam(0);
		$this->title = 'Редактирование галереи';

		$data['fields'] = $this->model->get($id);

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'title' => 'required',
				'code'  => 'required'
			)))
			{
				if($res = $this->model->edit($id, $_POST))
				{
					Url::setFlash('success', 'Информация успешно обновлена!', 'success');
					Url::redirect('/admin/gallery');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
		}

		$this->content = View::template('gallery/edit.php', $data);
		$this->generate();
	}

	public function delete()
	{
		$this->model->deleteGallery($this->getParam(0));

		Url::setFlash('success', 'Галерея удалена', 'success');
		Url::redirect('/admin/gallery');
	}
}