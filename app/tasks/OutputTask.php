<?php

namespace tasks;

class OutputTask extends AbstractTask
{
    public function usageAction()
    {
        echo PHP_EOL . 'Usage : php ./cron.php <task> <action> [<parameters>]';
    }
}
