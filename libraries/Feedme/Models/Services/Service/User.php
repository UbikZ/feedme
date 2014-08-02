<?php

namespace Feedme\Models\Services\Service;

use Feedme\Models\Dals\Dal;

class User
{
    public function getLast()
    {
        return Dal::getRepository('User')->getLast();
    }
}
