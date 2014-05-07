<?php
// Прослойка модели решает простые задачи
class Models_Base
{
	protected $table;
	protected $pk;
	private $db;

	public function __construct($table, $pk)
	{
		$this->table = $table;
		$this->pk    = $pk;
		$this->db    = DB::getInstance();
	}

	// protected function mysqlFix($str)
	// {
	// 	$str = htmlspecialchars($str);
	// 	$str = mysql_real_escape_string($str);
	// 	return $str;
	// }

	// public function all($order = array())
	// {
	// 	$sql = "SELECT * FROM {$this->table}";

	// 	if(!empty($order))
	// 	{
	// 		foreach($order as $k => $v)
	// 		{
	// 			$sql .= " ORDER BY $k $v";
	// 		}
	// 	}

	// 	return $this->db->select($sql);
	// }

	// public function add($fields, $table = null)
	// {
	// 	$table = $this->table;

	// 	if(!empty($table))
	// 		$table = $table;

	// 	$data = array();
	// 	foreach($fields as $item)
	// 	{
	// 		$data[] = $this->mysqlFix($item);
	// 	}
		
	// 	return $this->db->insert($table, $arr);
	// }

	// public function get($id, $where = array(), $order = array())
	// {
	// 	$sql = "SELECT * FROM {$this->table}";

	// 	if(!empty($where))
	// 	{
	// 		$i = 0;
	// 		foreach($where as $k => $v)
	// 		{
	// 			if($i)
	// 				$sql .=  " AND $k = " . $this->mysqlFix($v);
	// 			else
	// 				$sql .= " WHERE $k = " . $this->mysqlFix($v);
	// 			$i++;
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$sql .= " WHERE {$this->pk} = " . $this->mysqlFix($id);
	// 	}

	// 	if(!empty($order))
	// 	{
	// 		foreach($order as $k => $v)
	// 		{
	// 			$sql .= " ORDER BY $k $v";
	// 		}
	// 	}

	// 	$res = $this->db->select($sql);
	// 	if($res)
	// 		return $res[0];
	// }

	// public function edit($id, $fields, $where = null)
	// {
	// 	if(!$where)
	// 		$where = "{$this->pk} = $id";

	// 	$data = array();
	// 	foreach($fields as $k => $v)
	// 	{
	// 		$data[$k] = $this->mysqlFix($v);
	// 	}

	// 	return $this->db->update($this->table, $data, $where);
	// }

	// public function delete($id, $where = null)
	// {
	// 	if(!empty($where))
	// 		$where = "{$this->pk} = $id";

	// 	return $this->db->delete($this->table, $where);
	// }
}