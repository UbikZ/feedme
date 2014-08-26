<?php

namespace Feedme\Models\Services;

class Service
{
    private static $instances = array();

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
