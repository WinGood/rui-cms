<?php

/**
 * Хлебные крошечки
 * @author  Румянцев Олег
 * @version 0.2
 * Create: 23.07.13
 * Last.Update: 27.04.14
 */

class Breadcrumbs
{
	private static $previousKey;
	private static $names = array();
	private static $config = array();

	public static function getBreadcrumbs($titlePage = null)
	{
		$uri 	= trim(Url::getClearUri(), '/');		
		$crumbs = explode('/', $uri);		
		
		$breadcrumbs = array();
		$breadcrumbs['home'] = self::$config['home_link'];
		
		foreach ($crumbs as $item)
		{
			if (array_key_exists($item, self::$names))
			{
				$breadcrumbs['segments'][$item] = self::$names[$item];	
			}
		}
		
		if ($titlePage)
			$breadcrumbs['page'] = $titlePage;
		
		return self::generateHtml($breadcrumbs);
	}

	public static function init()
	{
		self::$names  = include(CORE_DIR.'br-names.php');
		self::$config = include(CORE_DIR.'br-config.php');
				
		// Подключаем динамические сущности
		$pages = DB::select('url', 'title')->from('pages')->execute();
		
		if ($pages)
		{
			$row = array();

			foreach ($pages as $item)
			{
				$row[$item['url']] = $item['title'];
			}

			self::$names = array_merge(self::$names, $row);
		}
	}
	
	/**
	 * Warning говно код, я вас предупредил
	 * @param array $breadcrumbs
	 * @return str:
	 */
	
	private static function generateHtml($breadcrumbs)
	{
		$countSegments 	= null;
		if (isset($breadcrumbs['segments']))
		{
			$countSegments = count($breadcrumbs['segments']);
		}
	
		$str  = self::$config['start_tag'];
		
		$str .= self::$config['tag_bre'];
		$str .= "<a href=".self::$config['home_link'].">".self::$config['name_home'].'</a>';
		$str .= self::$config['tag_separator'].self::$config['separator'].self::$config['close_tag_separator'];
		$str .= self::$config['close_tag_bre'];
		
		if ($countSegments)
		{
			$i = 0;
			foreach ($breadcrumbs['segments'] as $k => $v)
			{			
				$i++;
				if ($countSegments == $i AND !isset($breadcrumbs['page']))
				{
					$str .= self::$config['tag_bre'];
					if (self::$previousKey)
					{
						$str .= $v;
						self::$previousKey .= '/'.$k;
					}
					else
					{
						$str .= $v;
						self::$previousKey = $k;
					}					
					$str .= self::$config['close_tag_bre'];					
				}
				else
				{
					$str .= self::$config['tag_bre'];
					if (self::$previousKey)
					{
						$str .= "<a href=".trim(self::$config['home_link'], '/').'/'.self::$previousKey.'/'.$k.">".$v.'</a>';
						self::$previousKey .= '/'.$k;
					}
					else
					{
						$str .= "<a href=".trim(self::$config['home_link'], '/').'/'.$k.">".$v.'</a>';
						self::$previousKey = $k;
					}
					$str .= self::$config['tag_separator'].self::$config['separator'].self::$config['close_tag_separator'];
					$str .= self::$config['close_tag_bre'];					
				}							
			}
		}
		
		if (isset($breadcrumbs['page']))
		{
			$str .= self::$config['tag_bre'];
			$str .= $breadcrumbs['page'];
			$str .= self::$config['close_tag_bre'];			
		}
			
		$str .= self::$config['close_tag'];
				
		return $str;
	}
}