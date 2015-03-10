<?php

define('SITE', 'http://parceriaconsult.com.br');
define('CDN', 'http://parceriaconsult.com.br/static');
define('CORE', ROOT . DS . 'core');
define('PAGINAS', ROOT . DS . 'pages');
define('PARTIALS', ROOT . DS . 'partials');

require CORE . DS . 'functions.php';
require CORE . DS . 'seo.php';
require CORE . DS . 'router.php';

$route = new Router();
$route->load();