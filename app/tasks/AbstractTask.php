<?php

namespace tasks;

use Phalcon\CLI\Task;

abstract class AbstractTask extends Task
{
    public function mainAction()
    {
        echo PHP_EOL . "This is the default action of " . __CLASS__;
    }
}
