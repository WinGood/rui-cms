<?php
class Models_Widgets
{
	public function all()
	{
		return DB::select()->from('widgets')->execute();
	}

	public function get($id)
	{
		$res = DB::select()->from('widgets')->where('id_widget', '=', $id)->execute();
		return $res[0];
	}

	public function addWidget($data)
	{
		$data['path'] = trim($data['path'], '/');
		$pages        = isset($data['pages']) ? $data['pages'] : '';
		unset($data['pages']);

		$idWidget = DB::insert('widgets', $data)->execute();

		if(!empty($pages))
		{
			$wdt['path'] = $data['path'] . '/' . 'get/' . $idWidget;	
			$wdt['is_sort'] = 1;

			DB::update('widgets')->set($wdt)->where('id_widget', '=', $idWidget)->execute();

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

				DB::insert('widgets_sort', $obj)->execute();
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

			DB::insert('widgets_sort', $child)->execute();

			if($res = $this->checkChild($data[$j]['id_page']))
				$this->addChild($res, $data[$j]['id_page'], $idWidget);
		}
	}

	private function checkChild($idParent)
	{
		return DB::select('id_page')->from('pages')->where('id_parent', '=', $idParent)->execute();
	}

	public function editWidget($id, $data)
	{
		$data['path']    = trim($data['path'], '/');
		$pages           = isset($data['pages']) ? $data['pages'] : '';
		$data['is_sort'] = 0;
		unset($data['pages']);

		DB::delete('widgets_sort')->where('id_widget', '=', $id);

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

				DB::insert('widgets_sort', $obj)->execute();
			}
		}
		else
		{
			$data['path'] = $path[0];
		}

		DB::update('widgets')->set($data)->where('id_widget', '=', $id)->execute();

		return true;
	}

	public function deleteWidget($id)
	{
		DB::delete('widgets_sort')->where('id_widget', '=', $id)->execute();
		return DB::delete('widgets')->where('id_widget', '=', $id)->execute();
	}

	public function getWidgetByPath($path)
	{
		$res = DB::select()->from('widgets')->where('path', '=', $path)->execute();
		if($res) return $res[0];
	}

	public function getWidget($id)
	{
		$res = DB::select()->from('widgets')->where('id_widget', '=', $id)->execute();
		if($res) return $res[0];
	}

	public function getWidgetPages($idWidget)
	{
		return DB::select('id_page', 'title_in_menu', 'full_url', 'widgets_sort.id_parent')
				->from('pages')
				->join('widgets_sort')->using('id_page')
				->where('widgets_sort.id_widget', '=', $idWidget)
				->order('num_sort')
				->execute();
	}

	public function getWidgetPagesIds($idWidget)
	{
		$res = DB::select('id_page', 'title_in_menu', 'full_url')
				->from('pages')
				->join('widgets_sort')->using('id_page')
				->where('widgets_sort.id_widget', '=', $idWidget)
				->order('num_sort')
				->execute();

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