<?php

/*
 * Класс для работы с url
 */

class Url
{
	private static $_instance;
	private static $cutPath;
	private static $_isAdmin = null;

	private function __construct()
	{
		self::$cutPath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
		$uriArray      = array_slice(Url::getSections(), 1);

		if(!empty($uriArray) AND $uriArray[0] == 'admin')
			self::$_isAdmin = 1;

		// Редирект при обращении site-name/admin
		if((count($uriArray) == 1) AND ($uriArray[0] == 'admin'))
			self::redirect('/admin/main');
	}

	private function __clone(){}

	public static function isAdmin()
	{
		return self::$_isAdmin;
	}

	public static function init()
	{
		if(empty(self::$_instance))
			self::$_instance = new self;
		return self::$_instance;
	}

	public static function getSections($path = false)
	{
		if (!$path)
		{
			$uri = self::getClearUri();
		}
		else
		{
			$uri = $path;
		}

		$sections = explode('/', rtrim($uri, '/'));
		return $sections;
	}

	public static function getLastSection()
	{
		$sections = self::getSections();
		$lastSections = end($sections);

		return $lastSections;
	}

	public static function getClearUri()
	{
		$data = self::getDataUrl();

		if (self::$cutPath)
		{
			$pos = strpos($data['path'], self::$cutPath);
			if ($pos !== false)
			{
				$res = substr_replace($data['path'], '', $pos, strlen(self::$cutPath));
			}
		}
		else
		{
			$res = $data['path'];
		}

		return $res;
	}

	public static function getDataUrl($url = false)
	{
		if (!$url)
			$url = self::getUrl();

		return parse_url($url);
	}

	public static function getUrl()
	{
		return 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}

	public static function getCutSection()
	{
		return str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
	}

	public static function redirect($location, $redirect = '')
	{
		header('Location: '.$redirect.' '.SITE.$location);
		exit;
	}

	public static function redirectBack()
	{
		echo "<meta http-equiv=\"refresh\" content=\"0;url=" . $_SERVER['HTTP_REFERER'] . "\">";
		exit;
	}

	public static function baseUrl($path = NULL)
	{
		$url = SITE;
		if ($path)
			return $url .= '/'.trim($path, '/');
		else 
			return $url;
	}

	public static function isSection($name)
	{
		if(Route::getCurrentController() == $name)
			return TRUE;
	}

	public static function isCurrentPage($address)
	{
		$addArray 	  = explode('/', $address);
		$currAct      = Route::getCurrentAction();
		$currCtr      = Route::getCurrentController();
		$currAdr      = trim(self::getClearUri(), '/');

		if(($addArray[0] == $currCtr) && ($addArray[1] == $currAct) || ($address == $currAdr))
		{
			return true;
		}
	}

	public static function isActive($urlPage)
	{
		$url = trim(self::getClearUri(), '/');
		if(strpos($url, $urlPage) === 0)
		{
			$symb = substr($url, strlen($urlPage), 1);
			if(($symb === false || $symb == '/')) 
				return true;
		}
		else
		{
			if(($urlPage == 'home') && (!self::getLastSection()))
				return true;
		}
		return false;
	}

	public static function translitEncode($str)
	{
		$tr = array(
				"А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
				"Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
				"Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
				"О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
				"У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
				"Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
				"Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
				"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
				"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
				"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
				"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
				"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
				"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
				" "=> "-", "."=> "", "/"=> "-"
		);
			
		return strtolower(strtr($str,$tr));
	}
	
	public static function translitDecode($str)
	{
		$tr = array(
				'a' => 'а', 'b' => 'б', 'v' => 'в', 'g' => 'г',
				'd' => 'д','e' => 'е','j' => 'ж','z' => 'з','i' => 'и',
				'y' => 'й','k' => 'к','l' => 'л','m' => 'м','n' => 'н',
				'o' => 'о','p' => 'п','r' => 'р','s' => 'с','t' => 'т',
				'u' => 'у','f' => 'ф','h' => 'х','ts' => 'ц','ch' => 'ч',
				'sh' => 'ш','sch' => 'щ','yi' => 'ы','yu' => 'ю',
				'ya' => 'я','_' => ' '
		);
			
		return strtolower(strtr($str,$tr));
	}

	public static function getFlash($name)
	{
		if(isset($_SESSION['flash'][$name]))
		{
			$type = $_SESSION['flash'][$name]['type'];
			$msg  = $_SESSION['flash'][$name]['msg'];
			$html = '';
			$html .= "<div class='alert alert-$type'>";
			$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			$html .= $msg;
			$html .= "</div>";
			unset($_SESSION['flash'][$name]);
			return $html;
		}
	}

	public static function setFlash($name, $msg, $type)
	{
		$_SESSION['flash'][$name] = array('msg' => $msg, 'type' => $type);
	}

	// оооуу magic
	public static function addGet($url, $param, $pvalue = '')
	{
		$res = $url;
		if (($p = strpos($res, '?')) !== false) {
		  $paramsstr = substr($res, $p + 1);
		  $params = explode('&', $paramsstr);
		  $paramsarr = array();
		  foreach ($params as $value) {
		    $tmp = explode('=', $value);
		    if (isset($paramsarr[$tmp[0]])) {

		      if (is_array($paramsarr[$tmp[0]])) {
		        $paramsarr[$tmp[0]][] = (string) $tmp[1];
		      } else {
		        $temp = $paramsarr[$tmp[0]];
		        unset($paramsarr[$tmp[0]]);
		        $paramsarr[$tmp[0]][] = $temp;
		        $paramsarr[$tmp[0]][] = (string) $tmp[1];
		      }
		    } else {
		      $paramsarr[$tmp[0]] = (string) $tmp[1];
		    }
		  }
		  $paramsarr[$param] = $pvalue;
		  $res = substr($res, 0, $p + 1);

		  foreach ($paramsarr as $key => $value) {
		    if (is_array($value)) {
		      foreach ($value as $item) {
		        $str = $key;
		        if ($item !== '') {
		          $str .= '='.$item;
		        }
		        $res .= $str.'&';
		      }
		    } else {
		      $str = $key;
		      if ($value !== '') {
		        $str .= '='.$value;
		      }
		      $res .= $str.'&';
		    }
		  }
		  $res = substr($res, 0, -1);
		} else {
		  $str = $param;
		  if ($pvalue) {
		    $str .= '='.$pvalue;
		  }
		  $res .= '?'.$str;
		}
		return $res;
	}
}