<?php
class Controllers_Menus extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = new Models_Menus;

		$nav = array(
			'menus'     => 'Меню',
			'menus/add' => 'Добавить меню'
		);

		$this->setRightNav($nav);
	}

	public function index()
	{
		$this->title = 'Меню';
		$this->content = View::template('menus/index.php', array(
			'menuList' => $this->model->all()
		));
		$this->generate();
	}

	public function add()
	{
		$this->title = 'Добавление меню';
		$widgetsModel = new Models_Widgets;
		$this->scripts[] = 'jq-ui';
		$this->scripts[] = 'sortable';
		
		$data = array();
		$data['widgets_list'] = $widgetsModel->all();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'title' => 'required',
				'code' 	=> 'required'
			)))
			{
				if($res = $this->model->addMenu($_POST))
				{
					Url::setFlash('success', 'Меню успешно создано!', 'success');
					Url::redirect('/admin/menus');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
			$data['fields']['widgets'] = explode(',', $_POST['widgets']);
		}

		$this->content = View::template('menus/add.php', $data);
		$this->generate();
	}

	public function edit($params)
	{
		$this->title = 'Редактирование меню';
		$id = $this->isNum($params[0]);
		$widgetsModel = new Models_Widgets;
		$this->scripts[] = 'jq-ui';
		$this->scripts[] = 'sortable';

		$data = array();
		$data['fields'] = $this->model->getMenu($id);
		$data['widgets_list'] = $widgetsModel->all();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'title' => 'required',
				'code' 	=> 'required'
			)))
			{
				if($res = $this->model->editMenu($id, $_POST))
				{
					Url::setFlash('success', 'Меню успешно обновлено!', 'success');
					Url::redirect('/admin/menus');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
			$data['fields']['widgets'] = explode(',', $_POST['widgets']);
		}

		$this->content = View::template('menus/edit.php', $data);
		$this->generate();
	}
}