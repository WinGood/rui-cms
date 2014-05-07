<?php
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', 'root');
define('MYSQL_DB', 'specialist');

define('SITE_DIR', $_SERVER['DOCUMENT_ROOT'].'/');
define('CORE_DIR', 'core/');
define('CORE_LIB', 'lib/');
define('ADMIN_DIR', 'admin/');
define('TPL_DIR', 'template/');
define('VERSION', 0.1);

define('UPLOAD_DIR', 'upload/');
define('CKUPLOAD_DIR', UPLOAD_DIR.'ck/');
define('GALLERY_DIR', UPLOAD_DIR.'gallery/');
define('GALLERY_DIR_BIG', GALLERY_DIR.'big/');
define('GALLERY_DIR_SMALL', GALLERY_DIR.'small/');
define('IMG_SMALL_WIDTH', 200);
define('DOCS_DIR', UPLOAD_DIR.'docs/');

define('WIDGETS_REPLACE_PATTERN', '|<widget(.+?)>\[\[--(.+?)--\]\]</widget>|');
define('DOCS_TYPES', "/\.(?:pdf|xls|xlsx|doc|docx)$/i");