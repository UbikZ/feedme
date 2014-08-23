<?php

namespace Feedme\Models\Messages\Requests\UserWallMessage;

use Feedme\Models\Messages\Requests\Base;

class Insert extends Base
{
    /** @var  int */
    public $idMessageSrc;
    /** @var  int */
    public $idUserSrc;
    /** @var  int */
    public $idUserDest;
    /** @var  string */
    public $message;
}
