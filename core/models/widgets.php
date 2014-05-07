<?php
class Models_Widgets extends Models_Base
{
	public function __construct()
	{
		parent::__construct('widgets', 'id_widget');
	}

	public function addWidget($data)
	{
		$data['path'] = trim($data['path'], '/');
		$pages        = isset($data['pages']) ? $data['pages'] : '';
		unset($data['pages']);

		$idWidget = DB::getInstance()->insert('widgets', $data);

		if(!empty($pages))
		{
			$wdt['path'] = $data['path'] . '/' . 'get/' . $idWidget;	
			$wdt['is_sort'] = 1;
			$where = "id_widget = $idWidget";

			DB::getInstance()->update('widgets', $wdt, $where);

			// Если в виджете есть страницы, то заносим их в БД что бы можно было в 
			// дальнейшем сортировать

			for($i = 0; $i < count($pages); $i++)
			{
				if($children = $this->checkChild($pages[$i]))
				{
					$this->addChild($children, $pages[$i], $idWidget);
				}

				$obj['id_widget'] = $idWidget;
				$obj['id_page']  = $pages[$i];
				$obj['num_sort'] = $i;

				DB::getInstance()->insert('widgets_sort', $obj);
			}
		}

		return true;	
	}

	private function addChild($data, $parent, $idWidget)
	{
		for($j = 0; $j < count($data); $j++)
		{
			$child['id_widget'] = $idWidget;
			$child['id_parent'] = $parent;
			$child['id_page']   = $data[$j]['id_page'];
			$child['num_sort']  = $j;

			DB::getInstance()->insert('widgets_sort', $child);

			if($res = $this->checkChild($data[$j]['id_page']))
				$this->addChild($res, $data[$j]['id_page'], $idWidget);
		}
	}

	private function checkChild($idParent)
	{
		return DB::getInstance()->select("SELECT id_page FROM pages WHERE id_parent = $idParent");
	}

	public function editWidget($id, $data)
	{
		$data['path']    = trim($data['path'], '/');
		$pages           = isset($data['pages']) ? $data['pages'] : '';
		$data['is_sort'] = 0;
		unset($data['pages']);

		$where = "id_widget = $id";

		DB::getInstance()->delete('widgets_sort', $where);

		if(!empty($pages))
		{
			$data['is_sort'] = 1;

			// Если в виджете есть страницы, то заносим их в БД что бы можно было в 
			// дальнейшем сортировать
			
			for($i = 0; $i < count($pages); $i++)
			{
				if($children = $this->checkChild($pages[$i]))
				{
					$this->addChild($children, $pages[$i], $id);
				}

				$obj['id_widget'] = $id;
				$obj['id_page']  = $pages[$i];
				$obj['num_sort'] = $i;

				DB::getInstance()->insert('widgets_sort', $obj);
			}
		}
		else
		{
			$data['path'] = $path[0];
		}

		DB::getInstance()->update('widgets', $data, $where);

		return true;
	}

	public function deleteWidget($id)
	{
		$where = "id_widget = $id";
		DB::getInstance()->delete('widgets_sort', $where);
		return DB::getInstance()->delete('widgets', $where);
	}

	public function getWidgetByPath($path)
	{
		$res = DB::getInstance()->select("SELECT * FROM widgets WHERE path = '$path'");
		if($res)
			return $res[0];
	}

	public function getWidgetPages($idWidget)
	{
		return DB::getInstance()->select("
			SELECT id_page, title_in_menu, full_url, widgets_sort.id_parent
			FROM pages
			INNER JOIN widgets_sort using(id_page)
			WHERE widgets_sort.id_widget = $idWidget
			ORDER BY num_sort ASC
		");
	}

	public function getWidgetPagesIds($idWidget)
	{
		$res = DB::getInstance()->select("
			SELECT id_page, title_in_menu, full_url
			FROM pages
			INNER JOIN widgets_sort using(id_page)
			WHERE widgets_sort.id_widget = $idWidget
			ORDER BY num_sort ASC
		");

		$arr = array();
		if(!empty($res))
		{
			foreach($res as $item)
			{
				$arr[] = $item['id_page'];
			}
		}
		return $arr;
	}

	private function buildTree($rows, $idName, $pidName)
	{
		$children = array(); // children of each ID
		$ids = array();

		foreach ($rows as $i => $r)
		{
			$row =& $rows[$i];
			$id  = $row[$idName];
			$pid = $row[$pidName];
			$children[$pid][$id] =& $row;

			if (!isset($children[$id])) $children[$id] = array();

			$row['children'] =& $children[$id];
			$ids[$row[$idName]] = true;
		}

		// Root elements are elements with non-found PIDs.
		$forest = array();
		foreach ($rows as $i => $r)
		{
			$row =& $rows[$i];

			if (!isset($ids[$row[$pidName]]))
			{
				$forest[$row[$idName]] =& $row;
			}

			unset($row[$idName]); unset($row[$pidName]);
		}
		return $forest;
	}

	public function getThree($idWidget)
	{
		return $this->buildTree($this->getWidgetPages($idWidget), 'id_page', 'id_parent');
	}
}