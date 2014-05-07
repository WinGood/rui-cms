<?php
class User
{
	// Группы которые имеют доступ в админку
	private static $idRoleAdmin = array(1,3);

	public static function isAdmin()
	{
		if($user = self::get())
		{
			foreach(self::$idRoleAdmin as $role)
			{
				if($user['id_role'] == $role)
					return true;
			}
		}
	}

	public static function get()
	{
		if(isset($_SESSION['user']))
			return $_SESSION['user'];
	}

	public static function login($data)
	{
		$_SESSION['user'] = $data;
	}

	public static function logout()
	{
		unset($_SESSION['user']);
	}

	// Имеет ли пользователь данную привилегию
	public static function canLook($priv)
	{
		$model = new Models_User;
		$privs = $model->getPrivs();

		return (in_array('ALL', $privs)) || (in_array($priv, $privs));
	}
}