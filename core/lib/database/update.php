<?php
class Database_Update extends DB
{
	private $_sql;
	private $rows;

	public function __construct($table)
	{
		$this->_sql = "UPDATE `{$table}`";
	}

	public function set($vals)
	{
		$this->_sql .= " SET ";

		$arr = array();

		foreach ($vals as $k => $v)
		{
			$arr[] = "`{$k}` = ". (is_numeric($v) ? $v : "'" . $this->mysqlFix($v) ."'");
		}

		$this->_sql .= implode(',', $arr);
		return $this;
	}

	public function where($key, $operator, $val)
	{
		$this->_sql .= " WHERE";	
		$this->_sql .= " `{$key}` {$operator} " . (is_numeric($val) ? $val : "'" . $this->mysqlFix($val) ."'");
		return $this;
	}

	public function execute()
	{
		DB::getInstance()->_mysqli->query($this->_sql);
		return DB::getInstance()->_mysqli->affected_rows;
	}
}