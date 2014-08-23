<?php

class MainTask extends AbstractTask
{
    public function mainAction()
    {
        $this->console->handle(array('task' => 'output', 'action' => 'usage'));
    }
}
