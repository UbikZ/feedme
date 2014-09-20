<?php

namespace Feedme\Db;

use Feedme\Db\Exceptions\DriverException;
use Feedme\Db\Exceptions\ParametersException;
use Phalcon\Db\AdapterInterface;

class Factory
{
    /**
     * @param $conf
     * @return AdapterInterface
     * @throws Exceptions\ParametersException
     * @throws Exceptions\DriverException
     */
    public static function getDriver($conf)
    {
        if (!isset($conf["adapter"])) {
            throw new ParametersException("Driver parameter is missing");
        }
        $prefixAdapter = "Feedme\\Db\\Adapters\\";
        if (!class_exists($className = $prefixAdapter . $conf["adapter"])) {
            throw new DriverException("Database driver is not found");
        }
        unset($conf["adapter"]);

        return (new \ReflectionClass($className))->newInstance($conf);
    }
}
