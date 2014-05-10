<?php
class Database_Update extends DB
{
	private $_sql;
	private $_isWhere;
	private $_where = 'AND';

	public function __construct($table)
	{
		$this->_sql = "UPDATE `{$table}`";
	}

	public function set($vals, $htmlClear = false)
	{
		$this->_sql .= " SET ";

		$arr = array();

		foreach ($vals as $k => $v)
		{
			$arr[] = "`{$k}` = ". (is_numeric($v) ? $v : "'" . $this->mysqlFix($v, $htmlClear) ."'");
		}

		$this->_sql .= implode(',', $arr);
		return $this;
	}

	public function where($key, $operator, $val)
	{
		if(!$this->_isWhere) $this->_sql .= " WHERE"; else $this->_sql .= " {$this->_where}";
		$this->_sql .= " `{$key}` {$operator} " . (is_numeric($val) ? $val : "'" . $this->mysqlFix($val, true) ."'");
		$this->_isWhere = 1;
		return $this;
	}

	public function execute()
	{
		DB::getInstance()->_mysqli->query($this->_sql);
		return DB::getInstance()->_mysqli->affected_rows;
	}
}