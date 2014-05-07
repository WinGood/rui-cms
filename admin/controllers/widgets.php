<?php
class Controllers_Widgets extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = new Models_Widgets;

		$nav = array(
			'widgets'     => 'Виджеты',
			'widgets/add' => 'Создать виджет'
		);

		$this->setRightNav($nav);
	}

	public function index()
	{
		$this->title = 'Виджеты';

		$this->content = View::template('widgets/index.php', array(
			'widgets' => $this->model->all()
		));

		$this->generate();
	}

	public function add()
	{
		$this->title = 'Создание виджета';
		$pageModel = new Models_Pages;
		$data = array();
		$data['three'] = $pageModel->getThree();
		$data['fields']['pages'] = array();

		$this->scripts[] = 'script';

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'name'         => 'required',
				'name_in_menu' => 'required',
				'path'         => 'required'
			)))
			{
				if($res = $this->model->addWidget($_POST))
				{
					Url::setFlash('success', 'Виджет успешно создан!', 'success');
					Url::redirect('/admin/widgets');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
			if(empty($_POST['pages'])) $data['fields']['pages'] = array();
		}

		$this->content = View::template('widgets/add.php', $data);
		$this->generate();
	}

	public function edit($params)
	{
		if(!isset($params[0]))
			Url::redirect('/admin/widgets');
		$id = $params[0];

		$this->title = 'Редактирование виджета';
		$pageModel = new Models_Pages;
		$data['fields'] = $this->model->get($id);
		$data['three']  = $pageModel->getThree();
		$data['fields']['pages'] = $this->model->getWidgetPagesIds($id);

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'name'         => 'required',
				'name_in_menu' => 'required',
				'path'         => 'required'
			)))
			{
				if($res = $this->model->editWidget($id, $_POST))
				{
					Url::setFlash('success', 'Информация успешно обновлена!', 'success');
					Url::redirect('/admin/widgets');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
			if(empty($_POST['pages'])) $data['fields']['pages'] = array();
		}

		$this->content = View::template('widgets/edit.php', $data);
		$this->generate();
	}

	public function sort($params)
	{
		if(!isset($params[0]))
			Url::redirect('/admin/widgets');
		$id = $this->isNum($params[0]);

		$this->title = 'Сортировка элементов виджета';
		$this->scripts[] = 'jq-ui';
		$this->scripts[] = 'nestable/jquery.nestable';
		$this->scripts[] = 'nestable';

		$this->content = View::template('widgets/sort.php', array(
			'pages'  => $this->model->getThree($id),
			'fields' => $this->model->get($id)
		));

		$this->generate();
	}

	public function delete($params)
	{
		if(!isset($params[0]))
			Url::redirect('/admin/widgets');
		$id = $params[0];
		$this->model->deleteWidget($id);
		
		Url::setFlash('success', 'Виджет удален', 'success');
		Url::redirect('/admin/widgets');
	}
}