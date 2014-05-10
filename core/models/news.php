<?php
class Models_News
{
	public function all()
	{
		return DB::select()->from('news')->execute();
	}

	public function edit($id, $data)
	{
		return DB::update('news')->set($data)->where('id_news', '=', $id)->execute();
	}

	public function get($id)
	{
		$res = DB::select()->from('news')->where('id_news', '=', $id)->execute();
		return $res[0];
	}
}