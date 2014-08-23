<?php

namespace Feedme\Models\Messages\Requests\UserWall;

use Feedme\Models\Messages\Requests\Base;

class Insert extends Base
{
    /** @var  int */
    public $idUser;
    /** @var  string */
    public $idMessage;
}
