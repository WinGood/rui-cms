<?php
class Models_User extends Models_Base
{
	public function __construct()
	{
		parent::__construct('users', 'id_user');
	}

	public function searchUser($login, $pass)
	{
		$pass  = md5($pass);
		$login = $this->mysqlFix($login);

		$res = DB::getInstance()->select("SELECT * FROM users WHERE login = '$login' AND password = '$pass'");
		if($res)
			return $res[0];
	}

	public function getUser($login)
	{
		$login = $this->mysqlFix($login);

		$res = DB::getInstance()->select("SELECT * FROM users WHERE login = '$login'");
		if($res)
			return $res[0];
	}

	public function getUserById($id)
	{
		$id  = (int) $id;
		$res = DB::getInstance()->select("SELECT * FROM users WHERE id = $id");
		if($res)
			return $res[0];
	}

	public function getList()
	{
		return DB::getInstance()->select("SELECT * FROM users LEFT JOIN roles using(id_role)");
	}

	public function getRolesList()
	{
		return DB::getInstance()->select("SELECT * FROM roles");
	}

	public function getPrivs()
	{
		if(!isset($_SESSION['user']['id_role']))
			return array();

		$idRole = $_SESSION['user']['id_role'];
		$res = DB::getInstance()->select("SELECT privs.name as name FROM privs2roles JOIN privs using(id_priv) WHERE id_role = $idRole");

		$privs = array();

		foreach($res as $item)
		{
			$privs[] = $item['name'];
		}

		return $privs;
	}

	public function addUser($data)
	{
		$data['password'] = md5($data['password']);
		return DB::getInstance()->insert('users', $data);
	}

	public function addGroup($data)
	{
		return DB::getInstance()->insert('roles', $data);
	}

	public function editUser($id, $data)
	{
		if(!empty($data['password']))
			$data['password'] = md5($data['password']);
		else
			unset($data['password']);

		$where = "id = $id";
		return DB::getInstance()->update('users', $data, $where);
	}
}