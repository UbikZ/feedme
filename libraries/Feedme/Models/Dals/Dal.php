<?php

namespace Feedme\Models\Dals;

use Feedme\Models\Dals\Dal\BaseInterface;

class Dal
{
    /**
     * @var BaseInterface[]
     */
    private static $instances = array();

    /**
     * @param $name
     * @return BaseInterface
     * @throws Exceptions\InvalidRepositoryException
     */
    public static function getRepository($name)
    {
        if (!isset(self::$instances[$name])) {
            $className = "\\Feedme\\Models\\Dals\\Dal\\{$name}";
            if (!class_exists($className)) {
                throw new Exceptions\InvalidRepositoryException("Repository {$className} doesn't exists.");
            }
            self::$instances[$name] = (new \ReflectionClass($className))->newInstance();
        }

        return self::$instances[$name];
    }
}
