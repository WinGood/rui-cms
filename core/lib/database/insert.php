<?php
class Database_Insert extends DB
{
	private $_sql;
	private $table;
	private $rows;

	public function __construct($table, array $rows, $htmlClear = false)
	{
		$this->table = $table;
		$this->rows  = $rows;

		$this->_sql = "INSERT INTO `{$table}` SET ";

		$arr = array();

		foreach ($rows as $k => $v)
		{
			$v = $this->mysqlFix($v, $htmlClear);
			$arr[] = "`{$k}` = ". (is_numeric($v) ? $v : "'{$v}'");
		}

		$this->_sql .= implode(', ', $arr);	
	}

	public function execute()
	{
		DB::getInstance()->_mysqli->query($this->_sql);
		return DB::getInstance()->_mysqli->insert_id;
	}
}