<?php
// Не выводить предупреждения и ошибки.
//error_reporting(E_ALL & ~E_NOTICE);
setlocale(LC_ALL, 'ru_RU.UTF-8');
session_start();

header('Content-Type: text/html; charset=utf-8');

require_once('config.php');

// Установка путей, для поиска подключаемых библиотек.
set_include_path(get_include_path()
.PATH_SEPARATOR.CORE_DIR.CORE_LIB
.PATH_SEPARATOR.CORE_DIR
);

function __autoload($className)
{
	$path = str_replace('_', '/', strtolower($className));
	return include_once $path.'.php';
}

require_once(CORE_DIR.'bootstrap.php');
