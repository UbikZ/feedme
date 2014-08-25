<?php

defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));
define('ROOT_PATH', __DIR__ . '/..');
define('APP_PATH', ROOT_PATH . '/app');
define('CONF_PATH', APP_PATH . '/config');
define('LIBRARY_PATH', ROOT_PATH . '/libraries');
define('DATA_PATH', ROOT_PATH . '/data');
define('CACHE_PATH', ROOT_PATH . '/data/cache');
define('LOGS_PATH', ROOT_PATH . '/data/logs');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VENDOR_PATH', ROOT_PATH . '/vendor');

if (file_exists($path = VENDOR_PATH . '/autoload.php')) {
    include $path;
}

error_reporting(E_ALL);
