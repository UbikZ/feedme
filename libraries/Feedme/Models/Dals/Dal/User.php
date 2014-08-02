<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\User as EntityUser;

class User
{
    public function getLast()
    {
        return EntityUser::query()->order('datetime DESC')->execute();
    }
}
