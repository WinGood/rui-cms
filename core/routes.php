<?php
// Если не содержит admin или main или другой публичный модуль то пробуем найти page
return array(
	// Url вида user/username
	'^user/(?!login|logout|index)([-_a-z0-9]+)' => 'user/index/$1',
    '^(?!admin|main|user|widget|search|frontedit)([-_a-z0-9]+)' => 'pages/view/$1'
);