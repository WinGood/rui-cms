<?php
class Controllers_Users extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = new Models_User;

		$nav = array(
			'users'     	  => 'Пользователи',
			'users/add' 	  => 'Создать пользователя',
			'users/group/add' => 'Создать группу',
			'users/privs'	  => 'Права пользователей'
		);

		$this->setRightNav($nav);
	}

	public function index()
	{
		$this->title = 'Пользователи';

		$pagination = new Pagination(array(
			'table' => 'users',
			'join'  => 'LEFT JOIN roles using(id_role)'
		));

		$this->content = View::template('users/index.php',
			array(
				'users'      => $pagination->getPosts(),
				'pagination' => $pagination->getPagination()
			)
		);

		$this->generate();
	}

	public function group($params)
	{
		$action = $params[0];
		$data   = array();
		switch ($action)
		{
			case 'add':
				$this->title = 'Добавление группы пользователей';

				if($this->isPost())
				{
					if(!$err = Validation::run($_POST, array(
						'name'    	  => 'required',
						'description' => 'required'
					)))
					{
						if($res = $this->model->addGroup($_POST))
						{
							Url::setFlash('success', 'Группа успешно создана!', 'success');
							Url::redirect('/admin/users');
						}
					}
					else
					{
						Url::setFlash('error', $err, 'error');
					}

					$data['fields'] = $_POST;
				}

				$this->content = View::template('users/group/add.php', $data);
			break;
		}

		$this->generate();
	}

	public function add()
	{
		$this->title = 'Добавление пользователя';
		$data = array();
		$data['roles'] = $this->model->getRolesList();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'login'    => 'required',
				'password' => 'required'
			)))
			{
				if($res = $this->model->addUser($_POST))
				{
					Url::setFlash('success', 'Пользователь успешно создан!', 'success');
					Url::redirect('/admin/users');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
		}

		$this->content = View::template('users/add.php', $data);
		$this->generate();
	}

	public function edit($params)
	{
		$id = $this->getParam(0);
		$this->title = 'Редактирование пользователя';

		$data['fields'] = $this->model->getUserById($id);
		$data['roles'] = $this->model->getRolesList();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'login' => 'required'
			)))
			{
				if($res = $this->model->editUser($id, $_POST))
				{
					Url::setFlash('success', 'Информация пользователя успешно обновлена!', 'success');
					Url::redirect('/admin/users');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
		}

		$this->content = View::template('users/edit.php', $data);
		$this->generate();
	}

	public function privs()
	{
		$this->title = 'Права пользователей';
		$this->content = View::template('users/privs.php');
		$this->generate();
	}
}