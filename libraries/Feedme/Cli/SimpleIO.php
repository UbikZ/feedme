<?php

namespace Feedme\Cli;

class SimpleIO
{
    const INFO = 0;
    const ERROR = 1;

    public static function msg($msg, $type = null)
    {
        switch ($type) {
            case self::INFO:
                $prefix = '[INFO] ';
                break;
            case self::ERROR:
                $prefix = '[ERROR] ';
                break;
            default:
                $prefix = '';
                break;
        }
        $str =  $prefix . $msg . PHP_EOL;

        echo $str;
    }

    public static function error($msg, $target = 'Error')
    {
        self::msg("$target : $msg", self::ERROR);
    }

    public static function info($msg, $target = 'Info')
    {
        self::msg("$target : $msg", self::INFO);
    }

    public static function dump($msg)
    {
        echo '<pre>' . print_r($msg, true) . '</pre>' . PHP_EOL;
    }
}
