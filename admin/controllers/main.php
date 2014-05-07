<?php
class Controllers_Main extends Controllers_Base
{
	public function index()
	{
		$this->title = 'Dashboard';
		
		$this->content = View::template('main.php');
		$this->generate();
	}
}