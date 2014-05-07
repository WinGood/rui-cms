<?

/**
 * Файл инициализации
 * выполняется перед запуском приложения
 */

RUI::init();
Url::init();
Breadcrumbs::init();

$route = new Route();
$route->run();