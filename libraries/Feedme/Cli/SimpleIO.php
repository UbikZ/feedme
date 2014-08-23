<?php

namespace Feedme\Cli;

class SimpleIO
{
    const INFO = 0;
    const ERROR = 1;

    static function msg($msg, $type = null, $bExit = false)
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

    static function error($msg, $target = 'Error')
    {
        self::msg("$target : $msg", self::M_ERROR, true);
    }

    static function info($msg, $target = 'Info')
    {
        self::msg("$target : $msg", self::M_INFO, false);
    }

    static function dump($msg)
    {
        echo '<pre>' . print_r($msg, true) . '</pre>' . PHP_EOL;
    }
}