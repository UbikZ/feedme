<?php

namespace Feedme\Logger;

use Feedme\Logger\Exceptions\AdapterException;

class Factory
{
    public static function getLogger($path)
    {
        $adapter = "File";
        $prefixAdapter = "Feedme\\Logger\\Adapters\\";
        if (!class_exists($className = $prefixAdapter . $adapter)) {
            throw new AdapterException("Adapter is not found");
        }

        $filename = LOGS_PATH . "/$path-" . (new \DateTime())->format('Y-m-d') . ".log";
        
        return (new \ReflectionClass($className))->newInstance($filename);
    }
}
