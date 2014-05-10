<?php
class Models_Search
{
	private $searchRules;
	private static $_instance;

	private function __construct()
	{
		$this->searchRules = include(CORE_DIR.'search-rules.php');
	}

	public static function getInstance()
	{
		if(empty(self::$_instance))
			self::$_instance = new self;

		return self::$_instance;
	}

	public function find($string)
	{
		$string = preg_replace('/[|%_\']+/', '', $string);
		$string = htmlspecialchars($string);

		$results = array();

		foreach($this->searchRules as $key => $table)
		{
			if(count($table['fields'] > 0))
			{
				$where = $this->createCondition($table['fields'], $string);
				$dopWhere = ($table['where'] != '') ? " AND {$table['where']}" : '';
				$results[$key] = DB::getInstance()->query("SELECT * FROM $key WHERE ($where) $dopWhere");
			}
		}

		return $results;
	}

	public function getTemplate($table)
	{
		return $this->searchRules[$table]['template'];
	}

	private function createCondition($fields, $string)
	{
		$sets = array();

		foreach($fields as $field)
			$sets[] = " $field LIKE '%$string%'";

		return implode(' OR ', $sets);
	}
}