<?php

/**
 * Правила поиска по сайту
 */

return array(
	'pages' => array(
		'fields'   => array('title', 'content'),
		'where'    => "is_show = '1'",
		'template' => 'pages.php'
	),
	'users' => array(
		'fields'   => array('login'),
		'where'    => 'id_role = 1',
		'template' => 'users.php'
	)
);