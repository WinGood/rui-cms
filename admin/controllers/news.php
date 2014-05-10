<?php
class Controllers_News extends Controllers_Base
{
	private $model;

	public function __construct()
	{
		parent::__construct();
		$this->model = Model::factory('news');

		$nav = array(
			'news'          => 'Новости',
			'news/add'      => 'Добавить новость',
			'news/category' => 'Категории'
		);

		$this->setRightNav($nav);
	}

	public function index()
	{
		$this->title = 'Новости';
		
		$pagination = new Pagination(array(
			'table' => 'news',
			'order' => array('id_news' => 'DESC')
		));
			
		$data['news'] = $pagination->getPosts();
		$data['pagination'] = $pagination->getPagination();

		$this->content = View::template('news/index.php', $data);
		$this->generate();
	}
}