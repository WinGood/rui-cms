<?php
class Models_User
{
	public function searchUser($login, $pass)
	{
		$pass = md5($pass);
		$res  = DB::select()
				->from('users')
				->where('login', '=', $login)
				->where('password', '=', $pass)
				->execute();
		if($res) return $res[0];
	}

	public function getUser($login)
	{
		$res = DB::select()->from('users')->where('login', '=', $login)->execute();
		if($res) return $res[0];
	}

	public function getUserById($id)
	{
		$res = $res = DB::select()->from('users')->where('id', '=', $id)->execute();
		if($res) return $res[0];
	}

	public function getList()
	{
		return DB::select()->from('users')->leftJoin('roles')->using('id_role')->execute();
	}

	public function getRolesList()
	{
		return DB::select()->from('roles')->execute();
	}

	public function getPrivs()
	{
		if(!isset($_SESSION['user']['id_role'])) return array();

		$idRole = $_SESSION['user']['id_role'];
		$res    = DB::select('privs.name as name')
					->from('privs2roles')
					->join('privs')->using('id_priv')
					->where('id_role', '=', $idRole)
					->execute();

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
		return DB::insert('users', $data)->execute();
	}

	public function addGroup($data)
	{
		return DB::insert('roles', $data)->execute();
	}

	public function editUser($id, $data)
	{
		if(!empty($data['password']))
			$data['password'] = md5($data['password']);
		else
			unset($data['password']);

		return DB::update('users')->set($data)->where('id', '=', $id)->execute();
	}
}