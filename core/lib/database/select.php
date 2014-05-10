<?php
class Database_Select extends DB
{
	private $_sql;
	private $_isWhere;
	private $_where = 'AND';

	public function __construct(array $colums = null)
	{
		if(!$colums) $colums = array('*');
		$this->_sql = "SELECT " . implode(',', $colums);
	}

	public function from($table)
	{
		$this->_sql .= " FROM {$table}";
		return $this;
	}

	public function where($key, $operator, $val)
	{
		if(!$this->_isWhere) $this->_sql .= " WHERE"; else $this->_sql .= " {$this->_where}";
		
		if(strtoupper($operator) == 'IN')
			$this->_sql .= " {$key} " .strtoupper($operator). " (" . implode(',', $val) . ')';
		else
			$this->_sql .= " {$key} {$operator} " . (is_numeric($val) ? $val : "'" . $this->mysqlFix($val, true) ."'");

		$this->_isWhere = 1;
		return $this;
	}

	public function andWhere()
	{
		$this->_where = 'AND';
		return $this;
	}

	public function orWhere()
	{
		$this->_where = 'OR';
		return $this;
	}

	public function leftJoin($table)
	{
		$this->_sql .= " LEFT JOIN {$table}";
		return $this;
	}

	public function join($table)
	{
		$this->_sql .= " JOIN {$table}";
		return $this;
	}

	public function using($field)
	{
		$this->_sql .= " using({$field})";
		return $this;
	}

	public function on($fieldA, $operator, $fieldB)
	{
		$this->_sql .= " ON {$fieldA} {$operator} {$fieldB}";
		return $this;
	}

	public function order($field, $direction = 'asc')
	{
		$this->_sql .= " ORDER BY {$field} " . strtoupper($direction);
		return $this;
	} 

	public function execute()
	{
		$this->sql = $this->_sql;
		return parent::execute();
	}
}