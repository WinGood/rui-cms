<?php
class Controllers_Pages extends Controllers_Base
{
	private $model;
	private $modelMenu;

	public function __construct()
	{
		parent::__construct();
		$this->model = Model::factory('pages');
		$this->modelMenu = Model::factory('menus');

		$nav = array(
			'pages'     	=> 'Страницы',
			'pages/add' 	=> 'Добавить страницу',
			'pages/tpl/add' => 'Добавить шаблон'
		);

		$this->setRightNav($nav);
	}

	public function index()
	{
		$this->title = 'Страницы';
		$data['three'] = $this->model->getThree();

		if(isset($_GET['view']) && $_GET['view'] == 'list')
		{
			$pagination = new Pagination(array(
				'table' => 'pages',
				'order' => array('id_parent' => 'ASC')
			));
			
			$data['three'] = $pagination->getPosts();
			$data['pagination'] = $pagination->getPagination();
		}

		$this->content = View::template('pages/index.php', $data);
		$this->generate();
	}

	public function tpl()
	{
		$action = $this->getParam(0);
		switch ($action)
		{
			case 'add':
				$this->title = 'Добавление шаблона страниц';
				$data['files'] = $this->model->getTplFiles();

				if($this->isPost())
				{
					if(!$err = Validation::run($_POST, array(
						'name' => 'required',
						'path' => 'required'
					)))
					{
						if($res = $this->model->addTpl($_POST))
						{
							Url::setFlash('success', 'Шаблон успешно создан!', 'success');
							Url::redirect('/admin/pages');
						}
					}
					else
					{
						Url::setFlash('error', $err, 'error');
					}

					$data['fields'] = $_POST;
				}

				$this->content = View::template('pages/tpl.php', $data);
			break;
			
			default:
				Url::redirect('/admin/pages');
			break;
		}

		$this->generate();
	}

	public function add()
	{
		$this->title = 'Добавление страницы';
		$data = array();
		$data['fields']['is_show'] = 1;
		$data['fields']['id_menu'] = 1;
		$data['three'] = $this->model->getThree();
		$data['menu']  = $this->modelMenu->all();
		$data['tpl']   = $this->model->getTplList();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'title'         => 'required|min:10',
				'title_in_menu' => 'required',
				'url'           => 'required',
				'content'       => 'required'
			)))
			{
				if($res = $this->model->addPage($_POST))
				{
					Url::setFlash('success', 'Страница успешно добавлена!', 'success');
					Url::redirect('/admin/pages');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
		}

		$this->content = View::template('pages/add.php', $data);
		$this->generate();
	}

	public function edit()
	{
		$this->title = 'Редактирование страницы';
		$id   = $this->getParam(0);
		$data = array();
		$data['fields'] = $this->model->get($id);
		$data['three']  = $this->model->getThree();
		$data['menu']   = $this->modelMenu->all();
		$data['child']  = $this->model->getByParent($id);
		$data['tpl']    = $this->model->getTplList();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'title'         => 'required',
				'title_in_menu' => 'required',
				'url'           => 'required',
				'content'       => 'required'
			)))
			{
				if($id == $_POST['id_parent'])
				{
					Url::setFlash('error', 'Страница не может быть родителем самой себя', 'error');
				}
				else
				{
					if($res = $this->model->editPage($id, $_POST))
					{
						Url::setFlash('success', 'Страница успешно обновлена!', 'success');
						Url::redirect('/admin/pages');
					}
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
		}

		$this->content = View::template('pages/edit.php', $data);
		$this->generate();
	}

	public function delete()
	{
		$id = $this->getParam(0);
		$this->model->deletePage($id);
		echo $id;
	}
}