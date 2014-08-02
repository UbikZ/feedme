<?php

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'dev'));
define('ROOT_PATH', __DIR__ . '/..');
define('APP_PATH', ROOT_PATH . '/app');
define('LIBRARY_PATH', ROOT_PATH . '/libraries');
define('CACHE_PATH', ROOT_PATH . '/cache');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VENDOR_PATH', ROOT_PATH . '/vendor');

if (file_exists($path = VENDOR_PATH . '/autoload.php')) {
    include $path;
}

error_reporting(E_ALL);

$application = new \Feedme\Application();
$application->run();
