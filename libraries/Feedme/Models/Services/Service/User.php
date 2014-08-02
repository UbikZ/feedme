<?php

namespace Feedme\Models\Services\Service;

use Feedme\Models\Dals\Dal;

class User
{
    public function findFirst($email, $password)
    {
        return Dal::getRepository('User')->findFirst($email, $password);
    }

    public function getLast()
    {
        return Dal::getRepository('User')->getLast();
    }
}
