<?php
class View
{
	private static $layout = 'main.php';

	public static function template($fileName, $vars = array())
	{
		if(!empty($vars))
		{
			foreach ($vars as $k => $v)
			{
				$$k = $v;
			}
		}

		ob_start();
		if(Url::isAdmin())
		{
			include ADMIN_DIR.'views/'.$fileName;
		}
		else
		{
			if(file_exists(PATH_TEMPLATE.'/views/'.$fileName))
				include PATH_TEMPLATE.'/views/'.$fileName;
			else
				include CORE_DIR.'views/'.$fileName;
		}
		return ob_get_clean();	
	}

	public static function getLayout()
	{
		return self::$layout;
	}

	public static function setLayout($val)
	{
		self::$layout = $val;
	}
}