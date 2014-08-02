<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\User as EntityUser;

class User
{
    public function findFirst($username, $password)
    {
        $password = sha1($password);
        return EntityUser::findFirst("email='$email' AND password='$password' AND active='1'");
    }

    public function getLast()
    {
        return EntityUser::query()->order('datetime DESC')->execute();
    }
}
