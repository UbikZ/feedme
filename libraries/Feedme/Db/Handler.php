<?php

namespace Feedme\Db;

use Phalcon\Db\AdapterInterface;

class Handler
{
    /** @var  array */
    public static $conf;
    /** @var  AdapterInterface|null $instance */
    private static $instance = null;

    // Singleton <=> disable instanciation
    protected function __construct()
    {

    }

    // Singleton <=> disable cloning
    protected function __clone()
    {

    }

    public static function get()
    {
        if (null == self::$instance) {
            self::$instance = Factory::getDriver(self::$conf);
        }

        return self::$instance;
    }
}
