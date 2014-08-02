<?php

namespace Feedme\Models\Services;

class Service
{
    private static $_instances = array();

    public static function getService($name)
    {
        if (!isset(self::$_instances[$name])) {
            $className = "\\Feedme\\Models\\Services\\Service\\{$name}";
            if (!class_exists($className)) {
                throw new Exceptions\InvalidServiceException("Service {$className} doesn't exists.");
            }
            self::$_instances[$name] = (new \ReflectionClass($className))->newInstance();
        }

        return self::$_instance[$name];
    }
}
