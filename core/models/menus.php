<?php
class Models_Menus
{
	public function all()
	{
		return DB::select()->from('menu')->execute();
	}

	public function getMenuByCode($code)
	{
		$res = DB::select('id_menu')->from('menu')->where('code', '=', $code)->execute();
		$id  = $res[0]['id_menu'];
		$res = DB::select()
				->from('menu_widget')
				->join('widgets')->using('id_widget')
				->where('menu_widget.id_menu', '=', $id)
				->order('num_sort')
				->execute();

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
		$res = DB::select()
				->from('menu_widget')
				->join('widgets')->using('id_widget')
				->where('menu_widget.id_menu', '=', $id)
				->order('num_sort')
				->execute();
		
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
		$idMenu = DB::insert('menu', array(
			'title' => $data['title'],
			'code'  => $data['code']
		))->execute();

		if(!empty($data['widgets']))
		{
			$widgets = explode(',', $data['widgets']);
			$obj = array('id_menu' => $idMenu);

			for($i = 0; $i < count($widgets); $i++)
			{
				$obj['id_widget'] = $widgets[$i];
				$obj['num_sort']  = $i;
				DB::insert('menu_widget', $obj)->execute();
			}
			return $idMenu;
		}
		
		return true;
	}
	
	public function getMenu($id)
	{
		$res   = DB::select()->from('menu')->where('id_menu', '=', $id)->execute();
		$menu  = $res[0];
		
		$pages = DB::select('id_widget')->from('menu_widget')->where('id_menu', '=', $menu['id_menu'])->order('num_sort')->execute();
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
		$widget = $data['widgets'];
		unset($data['widgets']);

		DB::delete('menu_widget')->where('id_menu', '=', $id)->execute();
		DB::update('menu')->set($data)->where('id_menu', '=', $id)->execute();

		if(!empty($widget))
		{
			$widgets = explode(',', $widget);
			$obj = array('id_menu' => $id);

			for($i = 0; $i < count($widgets); $i++)
			{
				$obj['id_widget']  = $widgets[$i];
				$obj['num_sort'] = $i;
				DB::insert('menu_widget', $obj)->execute();
			}

			return $id;
		}
		
		return true;
	}
}