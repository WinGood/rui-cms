<?php
class Database_Delete extends DB
{
	private $_sql;

	public function __construct($table)
	{
		$this->_sql = "DELETE FROM `{$table}`";
	}

	public function where($key, $operator, $val)
	{
		$this->_sql .= " WHERE";	

		if(strtoupper($operator) == 'IN')
			$this->_sql .= " `{$key}` " .strtoupper($operator). " (" . implode(',', $val) . ')';
		else
			$this->_sql .= " `{$key}` {$operator} " . (is_numeric($val) ? $val : "'" . $this->mysqlFix($val) ."'");

		return $this;
	}

	public function execute()
	{
		DB::getInstance()->_mysqli->query($this->_sql);
		return DB::getInstance()->_mysqli->affected_rows;
	}
}