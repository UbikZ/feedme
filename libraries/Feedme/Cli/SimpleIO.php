<?php

namespace Feedme\Cli;

class SimpleIO
{
    const INFO = 0;
    const ERROR = 1;

    public static function msg($msg, $type = null, $bExit = false)
    {
        switch ($type) {
            case self::M_INFO:
                $m = '[INFO] ';
                break;
            case self::M_ERROR:
                $m = '[ERROR] ';
                break;
            default:
                $m = '';
                break;
        }
        echo $m . $msg . PHP_EOL;
        if ($bExit) {
            exit();
        }
    }

    public static function error($msg, $target = 'Error')
    {
        self::msg("$target : $msg", self::M_ERROR, true);
    }

    public static function info($msg, $target = 'Info')
    {
        self::msg("$target : $msg", self::M_INFO, false);
    }

    public static function dump($msg)
    {
        echo '<pre>' . print_r($msg, true) . '</pre>' . PHP_EOL;
    }
}
