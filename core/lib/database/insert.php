<?php
class Database_Insert extends DB
{
	private $_sql;
	private $table;
	private $rows;

	public function __construct($table, $rows)
	{
		$this->table = $table;
		$this->rows  = $rows;

		$this->_sql = "INSERT INTO `{$table}` (";

		$arr = array();

		foreach($rows as $row)
		{
			$arr[] = (is_numeric($row) ? $row : "`{$row}`");
		}

		$this->_sql .= implode(', ', $arr) . ')';
	}

	public function values($vals)
	{
		$this->_sql .= " VALUES (";

		$arr = array();
		foreach ($vals as $item)
		{
			$arr[] = (is_numeric($item) ? $item : "'" . $this->mysqlFix($item) ."'");
		}

		$this->_sql .= implode(', ', $arr) .')';
		return $this;
	}

	public function execute()
	{
		DB::getInstance()->_mysqli->query($this->_sql);
		return DB::getInstance()->_mysqli->insert_id;
	}
}