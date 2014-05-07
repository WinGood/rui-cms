<?php
class DB
{
	private static $_instance;
	protected $_mysqli;
	protected $sql;

	private function __construct()
	{
		$this->_mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
		if($this->_mysqli->connect_errno)
			echo "Не удалось подключиться к MySQL: (" . $this->_mysqli->connect_errno . ") " . $this->_mysqli->connect_error;	
		$this->_mysqli->query("SET NAMES utf8");
	}

	private function __destroy()
	{
		$this->_mysqli->close();	
	}

	protected function mysqlFix($str)
	{
		$str = htmlspecialchars($str);
		$str = mysql_real_escape_string($str);
		return $str;
	}

	public static function getInstance()
	{
		if(empty(self::$_instance))  
		     self::$_instance = new self;

		 return self::$_instance;
	}

	public static function select()
	{
		return new Database_Select(func_get_args());
	}

	public static function insert($table, $rows)
	{
		return new Database_Insert($table, $rows);
	}

	public static function update($table)
	{
		return new Database_Update($table);
	}

	public static function delete($table)
	{
		return new Database_Delete($table);
	}

	public function execute()
	{
		$query   = DB::getInstance()->_mysqli->query($this->sql); 
		$numRows = $query->num_rows;
		$result  = array();

		if ($numRows > 0)
		{			
			for ($i = 0; $i < $numRows; $i++)
			{
				$row = $query->fetch_assoc();
				$result[] = $row;
			}
		}
		
		return $result;	
	}

	private function __clone(){}

}