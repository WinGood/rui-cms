<?php
class Models_Pages
{
	public function all()
	{
		return DB::select()->from('pages')->execute();
	}

	public function edit($id, $data)
	{
		return DB::update('pages')->set($data)->where('id_page', '=', $id)->execute();
	}

	public function get($id)
	{
		$res = DB::select()->from('pages')->where('id_page', '=', $id)->execute();
		return $res[0];
	}

	public function addPage($data)
	{
		$data['full_url'] = $this->makeFullUrl($data['id_parent'], $data['url']);
		return DB::insert('pages', $data)->execute();
	}

	public function addTpl($data)
	{
		return DB::insert('pages_tpl', $data)->execute();
	}

	public function getTplFiles()
	{
		$files = array();
		$dir = opendir(CORE_DIR.'views/layout/pages');
		
		while (FALSE !== ($file = readdir($dir)))
		{
			if ($file == 'Thumbs.db' OR $file == '..' OR $file == '.' OR $file == '.DS_Store') continue;							
			$files[] = $file;
		}

		return $files;
	}

	public function getTplList()
	{
		return DB::select()->from('pages_tpl')->execute();
	}

	public function getTpl($id)
	{
		$res = DB::select('path')->from('pages_tpl')->where('id_tpl', '=', $id)->execute();
		return $res[0];
	}

	public function getByParent($idParent)
	{
		return DB::select()->from('pages')->where('id_parent', '=', $idParent)->execute();
	}

	public function getThree($parent = 0)
	{
		$three = array();
		$category = DB::select()->from('pages')->where('id_parent', '=', $parent)->execute();
		if(!empty($category))
		{
			foreach($category as $item)
			{
				$item['children'] = $this->getThree($item['id_page']);
				$three[] = $item;
			}
		}
		return $three;
	}

	public function getThreeList($id)
	{
		$res = array();
		if(is_array($id))
		{
			foreach($id as $item)
			{
				$page  = $this->get($item);
				$child['children'] = $this->getThree($item);
				$res[] = array_merge($page, $child);
			}
		}
		else
		{
			$page  = $this->get($id);
			$child['children'] = $this->getThree($id);
			$res   = array_merge($page, $child);
		}

		return $res;
	}

	public function getPageUrl($url)
	{
		$res = DB::select()->from('pages')->where('full_url', '=', $url)->execute();
		return $res[0];
	}

	public function frontEdit($id, $data)
	{
		unset($data['act']);
		unset($data['id']);
		$where = "id_page = $id";
		return $this->edit($id, $data);
	}

	public function editPage($id, $data)
	{
		$data['full_url'] = $this->makeFullUrl($data['id_parent'], $data['url']);

		DB::update('pages')->set($data)->where('id_page', '=', $id)->execute();
		$this->changeUrl($id);

		return true;
	}

	public function deletePage($id)
	{
		$page = $this->get($id);
		//$this->changeUrl($id, $page['url']);
		//$this->delete($id);
	}

	private function changeUrl($idParent, $delete = false)
	{
		$children = DB::getInstance()->select("SELECT * FROM pages WHERE id_parent = $idParent");
		$page = array();

		foreach($children as $child)
		{
			$page['full_url'] = $this->makeFullUrl($child['id_parent'], $child['url'], $delete);
			$where = "id_page = $child[id_page]";
			// echo '<pre>';
			// print_r($page);
			// echo '</pre>';
			DB::getInstance()->update('pages', $page, $where);
			$this->changeUrl($child['id_page']);
		}
	}

	private function makeFullUrl($idParent, $url, $delete = false)
	{
		if($idParent == 0) return $url;
		$page = $this->get($idParent);

		// if($delete)
		// {
		// 	$uri = explode('/', $page['full_url']);
		// 	$url = array();
		// 	foreach($uri as $item)
		// 	{
		// 		if($item == $delete)
		// 			continue;
		// 		$url[] = $item;
		// 	}
		// 	return implode('/', $url);
		// }

		return $page['full_url'] . '/' . $url;
	}
}