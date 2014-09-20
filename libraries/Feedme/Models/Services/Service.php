<?php

namespace Feedme\Models\Services;

use Feedme\Models\Services\Service\ServiceInterface;

class Service
{
    /**
     * @var ServiceInterface[]
     */
    private static $instances = array();

    /**
     * @param $name
     * @return ServiceInterface
     * @throws Exceptions\InvalidServiceException
     */
    public static function getService($name)
    {
        if (!isset(self::$instances[$name])) {
            $className = "\\Feedme\\Models\\Services\\Service\\{$name}";
            if (!class_exists($className)) {
                throw new Exceptions\InvalidServiceException("Service {$className} doesn't exists.");
            }
            self::$instances[$name] = (new \ReflectionClass($className))->newInstance();
        }

        return self::$instances[$name];
    }
}
