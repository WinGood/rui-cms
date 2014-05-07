<?php

/**
 * Роутер опр. контроллер, экшен и параметры
 */

class Route
{
	private $routes = array();
	private $_isRoute;
	private $controller;
	private $action;
	private $parameters = array();
	private $_isAdmin = null;
	
	private static $controllerName;
	private static $actionName;

	public function __construct()
	{
		$this->routes = include(CORE_DIR.'routes.php');
	}

	public function run($uri = null)
	{
		// Если идет обычное обращение не через метод Controller_Base->request
		if(!$uri)
		{
			$uri      = trim(Url::getClearUri(), '/');
			$uriArray = array_slice(Url::getSections(), 1);
			$admin    = '';

			if(!empty($uriArray) AND $uriArray[0] == 'admin')
				$this->_isAdmin = 1;
		}

		if(!empty($uri))
		{
			// Пробуем соответствие в регулярках
			foreach ($this->routes as $pattern => $route)
			{
				if (preg_match("~$pattern~", $uri))
				{
					$internalRoute = preg_replace("~$pattern~", $route, $uri);
					$this->setData($internalRoute);
					$this->_isRoute = TRUE;
					break;
				}
			}
			// Если ничего не найдено то просто разбираем uri строку
			if (!$this->_isRoute)
			{
				$this->setData($uri);		
			}
		}
		else
		{
			$this->controller = 'main';
			$this->action = 'index';
		}
		
		self::$controllerName = strtolower($this->controller);
		self::$actionName 	  = strtolower($this->action);
		$this->controller     = 'Controllers_'.ucfirst($this->controller);
		
		if(!$this->selectController($this->_isAdmin))
		{
			RUI::show404();
		}
	}

	private function setData($uri)
	{
		$segments = explode('/', $uri);
		// Костыль
		if($this->_isAdmin)
		{
			$this->controller = $segments[0+$this->_isAdmin];

			if(empty($segments[1+$this->_isAdmin]))
				$this->action = 'index';
			else
				$this->action = $segments[1+$this->_isAdmin];

			$this->parameters = array_slice($segments, 2+$this->_isAdmin);
		}
		else
		{
			$this->controller = $segments[0];

			if(empty($segments[1]))
				$this->action = 'index';
			else
				$this->action = $segments[1];

			$this->parameters = array_slice($segments, 2+$this->_isAdmin);
		}
	}

	private function selectController($admin = false)
	{
		if($this->_isAdmin)
		{
			restore_include_path();
			set_include_path(get_include_path()
			.PATH_SEPARATOR.ADMIN_DIR
			.PATH_SEPARATOR.CORE_DIR.CORE_LIB
			.PATH_SEPARATOR.CORE_DIR
			);
		}

		$action = $this->action;

		if (@class_exists($this->controller))
		{
			$ref = new ReflectionClass($this->controller);
			// Если в классе существует такой метод
			if ($ref->hasMethod($action))
			{
				$method  = $ref->getMethod($action);
				// Если метод приватный(его нельзя вызвать)
				if($method->isPrivate())
				{
					return FALSE;
				}
				else
				{
					$obj = new $this->controller;

					$param = array();
					if(!empty($this->parameters))
					{
						foreach($this->parameters as $item)
						{
							$item = preg_replace('/[|%_\']+/', '', $item);
							$item = htmlspecialchars($item);
							$item = mysql_real_escape_string($item);
							
							$param[] = $item;
						}
					}

					RUI::set('URI_PARAMS', $param);
					$obj->$action($this->parameters);
					return $obj;
				}
			}
			else
			{
				return FALSE;
			}
		}	
	}

	public static function getCurrentController()
	{
		return self::$controllerName;
	}

	public static function getCurrentAction()
	{
		return self::$actionName;
	}
}