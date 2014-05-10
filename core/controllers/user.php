<?php
class Controllers_User extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = Model::factory('user');
	}

	public function index()
	{
		$login = $this->getParam(0);	
		if(empty($login)) Url::redirect('/user/login');

		$user = $this->model->getUser($login);
		$this->setTitle('Профиль пользователя - ' . $user['login']);

		$data            = array();
		$curUser         = User::get();
		$data['user']    = $user;
		$data['current'] = ($curUser['login'] == $login) ? 1 : null;

		$this->content = View::template('user/profile.php', $data);
		$this->generate();
	}

	public function login()
	{
		if($res = User::get()) Url::redirect('/user/'.$res['login']);

		$this->setTitle('Авторизация пользователя');
		$data = array();

		if($this->isPost())
		{
			if(!$err = Validation::run($_POST, array(
				'login'     => 'required',
				'password' 	=> 'required'
			)))
			{
				if($res = $this->model->searchUser($_POST['login'], $_POST['password']))
				{
					User::login($res);
					Url::redirect('/user/'.$res['login']);
				}
				else
				{
					Url::setFlash('error', 'Пользователь не найден', 'error');
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}

			$data['fields'] = $_POST;
		}

		$this->content = View::template('user/login.php');
		$this->generate();
	}

	public function logout()
	{
		User::logout();
		Url::setFlash('success', 'Операция выполнена', 'success');
		Url::redirect('/user/login');
	}
}