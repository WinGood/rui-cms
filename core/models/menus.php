<?php
class Models_Menus extends Models_Base
{
	public function __construct()
	{
		parent::__construct('menu', 'id_menu');
	}

	public function getMenuByCode($code)
	{
		$res = DB::select('id_menu')->from('menu')->where('code', '=', $code)->execute();
		$id  = $res[0]['id_menu'];
		$res = DB::select()
				->from('menu_widget')
				->join('widgets')
				->using('id_widget')
				->where('menu_widget.id_menu', '=', $id)
				->order('num_sort', 'asc')
				//->printSql();
				->execute();
		// $res = DB::getInstance()->select("
		// 	SELECT * FROM menu_widget
		// 	JOIN widgets using(id_widget)
		// 	WHERE menu_widget.id_menu = $id
		// 	ORDER BY num_sort ASC");

		$arr = array();
		foreach($res as $item)
		{
			$item['path'] = '<widget data-type="widget">[[--widget/'. $item['path'] .'--]]</widget>';
			$arr[] = $item;
		}

		return $arr;
	}

	public function getMenuById($id)
	{
		$res = DB::getInstance()->select("
			SELECT * FROM menu_widget
			JOIN widgets using(id_widget)
			WHERE menu_widget.id_menu = $id
			ORDER BY num_sort ASC");
		
		$arr = array();
		foreach($res as $item)
		{
			$item['path'] = '<widget data-type="widget">[[--widget/'. $item['path'] .'--]]</widget>';
			$arr[] = $item;
		}

		return $arr;
	}

	public function addMenu($data)
	{
		$idMenu = DB::getInstance()->insert('menu', array(
			'title' => $data['title'],
			'code'  => $data['code']
		));

		if(isset($data['widgets']))
		{
			$widgets = explode(',', $data['widgets']);
			$obj = array('id_menu' => $idMenu);

			for($i = 0; $i < count($widgets); $i++)
			{
				$obj['id_widget']  = $widgets[$i];
				$obj['num_sort'] = $i;
				DB::getInstance()->insert('menu_widget', $obj);
			}
			return $idMenu;
		}
		
		return true;
	}
	
	public function getMenu($id)
	{
		$res   = DB::getInstance()->select("SELECT * FROM menu WHERE id_menu = $id");
		$menu  = $res[0];
		
		$pages = DB::getInstance()->select("SELECT id_widget FROM menu_widget WHERE id_menu = $menu[id_menu] ORDER BY num_sort ASC");
		$row   = array();
		
		foreach($pages as $page)
		{
			$row[] = $page['id_widget'];
		}

		$menu['widgets'] = $row;
		return $menu;
	}

	public function editMenu($id, $data)
	{
		$where = "id_menu = $id";
		DB::getInstance()->delete('menu_widget', $where);

		DB::getInstance()->update('menu', array(
			'title' => $data['title'],
			'code'  => $data['code']
		), $where);

		if(!empty($data['widgets']))
		{
			$widgets = explode(',', $data['widgets']);
			$obj = array('id_menu' => $id);

			for($i = 0; $i < count($widgets); $i++)
			{
				$obj['id_widget']  = $widgets[$i];
				$obj['num_sort'] = $i;
				DB::getInstance()->insert('menu_widget', $obj);
			}

			return $id;
		}
		
		return true;
	}
}