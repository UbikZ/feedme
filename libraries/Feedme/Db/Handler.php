<?php

namespace Feedme\Db;

use Phalcon\Db\AdapterInterface;

class Handler
{
    /** @var  array */
    public static $conf;
    /** @var  AdapterInterface|null $_instance */
    private static $_instance = null;

    // Singleton <=> disable instanciation/cloning
    protected function __construct() {}
    protected function __clone() {}

    public static function get()
    {
        if (null == self::$_instance) {
            self::$_instance = Factory::getDriver(self::$conf);
        }

        return self::$_instance;
    }
}
