<?php
class Controllers_Search extends Controllers_Base
{
	public function index()
	{
		$data = array();
		
		if($this->isPost())
		{
			$this->setTitle('Поиск по фразе - '.$_POST['search']);

			if(!$err = Validation::run($_POST, array(
				'search' => 'required|min:3'
			)))
			{
				$data['result'] = Models_Search::getInstance()->find($_POST['search']);
				$templates = array();

				if($data['result'])
				{
					foreach($data['result'] as $k => $v)
					{
						if(!empty($v))
						{
							// Для каждой сущности у нас свой шаблон вывода
							// "Склеиваем" их в один
							$templates[] = View::template('search/'.Models_Search::getInstance()->getTemplate($k), array(
								'data' => $v
							));
						}
					}
					$data['result'] = $templates;
				}
			}
			else
			{
				Url::setFlash('error', $err, 'error');
			}
		}
		else
		{
			Url::redirect('/');
		}

		$this->content = View::template('search/all.php', $data);
		$this->generate();
	}
}