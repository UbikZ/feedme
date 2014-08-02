<?php

namespace Feedme\Models\Dals;

class Dal
{
    private static $_instances = array();

    public static function getRepository($name)
    {
        if (!isset(self::$_instances[$name])) {
            $className = "\\Feedme\\Models\\Dals\\Dal\\{$name}";
            if (!class_exists($className)) {
                throw new Exceptions\InvalidRepositoryException("Repository {$className} doesn't exists.");
            }
            self::$_instances[$name] = (new \ReflectionClass($className))->newInstance();
        }

        return self::$_instances[$name];
    }
}
