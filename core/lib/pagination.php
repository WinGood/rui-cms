<?php

/**
 * Постраничная навигация
 * @author  Румянцев Олег
 * @version 0.2
 * Create: 23.07.13
 * Last.Update: 18.04.14
 */

class Pagination
{
	private $page;
	private $table;
		
	private $postNumber = 5;
	private $numberLink = 5;
	private $url;
	private $urlParams;
	
	private $total;
	
	private $where;
	private $order;
	private $join;
	private $sql;
	private $totalPosts;
	
	private $navigation = array();

	public function __construct($data)
	{
		foreach($data as $k => $v)
		{
			$this->$k = $v; 
		}

		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		if(!$page) $page = 1;
		$this->page = $page;

		$sql = "SELECT * FROM $this->table";

		if($this->join)
		{
			$sql .= " $this->join";
		}

		if($this->where)
		{
			foreach($this->where as $k => $v)
			{
				$sql .= " WHERE $k = $v";
			}
		}

		if($this->order)
		{
			foreach($this->order as $k => $v)
			{
				$sql .= " ORDER BY $k $v";
			}
		}

		$this->sql = $sql;
		$res = DB::getInstance()->query($this->sql);
		$this->totalPosts = count($res);

		$this->getNavigation();
	}

	private function getNavigation()
	{
		$number_pages = (int) ($this->totalPosts/$this->postNumber);
		
		if (($this->totalPosts % $this->postNumber) != 0) $number_pages++;		
		if ($this->totalPosts < $this->postNumber OR $this->page > $number_pages) return FALSE;
		
		$res = array();
		
		if ($this->page != 1) {
			$res['first'] = 1;
			$res['previous_page'] = $this->page - 1;
		}
		
		if ($this->page > $this->numberLink + 1)
		{
			for ($i = $this->page - $this->numberLink; $i < $this->page; $i++)
			{
				$res['previous_links'][] = $i;
			}
		}
		else {
			for ($i = 1; $i < $this->page; $i++)
			{
				$res['previous_links'][] = $i;
			}
		}
		
		$res['current'] = $this->page;
		
		if ($this->page + $this->numberLink < $number_pages)
		{
			for ($i = $this->page + 1; $i <= $this->page + $this->numberLink; $i++)
			{
				$res['next'][] = $i;
			}
		}
		else {
			for ($i = $this->page + 1; $i <= $number_pages; $i++)
			{
				$res['next'][] = $i;
			}
		}
		
		if ($this->page != $number_pages)
		{
			$res['next_page']  = $this->page + 1;
			$res['last_page']  = $number_pages;
		}
		
		$this->navigation = $res;
	}
	
	public function getPosts()
	{
		$number_pages = (int) ($this->totalPosts/$this->postNumber);
		
		if (($this->totalPosts % $this->postNumber) != 0) $number_pages++;				
		if ($this->page <= 0 OR $this->page > $number_pages) return FALSE;
		
		$start = ($this->page - 1) * $this->postNumber;
		$this->sql .= " LIMIT $start, $this->postNumber";

		return DB::getInstance()->query($this->sql);
	}
	
	public function getPagination()
	{
		$str = '';
		$str .= '<ul>';

		if (isset($this->navigation['first'])) 		   $str .= "<li><a href=".Url::baseUrl(Url::addGet($_SERVER['REQUEST_URI'], 'page' , 1)).">Первая</a></li>";
		if (isset($this->navigation['previous_page'])) $str .= "<li><a href=".Url::baseUrl(Url::addGet($_SERVER['REQUEST_URI'], 'page' , $this->navigation['previous_page'])).">&lt</a></li>";
		if (isset($this->navigation['previous_links']))
		{
			foreach ($this->navigation['previous_links'] as $item)
			{
				$str .= "<li><a href=".Url::baseUrl(Url::addGet($_SERVER['REQUEST_URI'], 'page' , $item)).">$item</a></li>";
			}
		}
		if (isset($this->navigation['current'])) $str .= "<li class='active'><a href=".Url::baseUrl(Url::addGet($_SERVER['REQUEST_URI'], 'page' , $this->navigation['current'])).">".$this->navigation['current']."</a></li>";
		if (isset($this->navigation['next']))
		{
			foreach ($this->navigation['next'] as $item)
			{
				$str .= "<li><a href=".Url::baseUrl(Url::addGet($_SERVER['REQUEST_URI'], 'page' , $item)).">$item</a></li>";
			}
		}
		if (isset($this->navigation['next_page'])) $str .= "<li><a href=".Url::baseUrl(Url::addGet($_SERVER['REQUEST_URI'], 'page' , $this->navigation['next_page'])).">&gt</a></li>";
		if (isset($this->navigation['last_page'])) $str .= "<li><a href=".Url::baseUrl(Url::addGet($_SERVER['REQUEST_URI'], 'page' , $this->navigation['last_page'])).">Последняя</a></li>";
	
		$str .= '</ul>';
		
		return $str;
	}
	
}