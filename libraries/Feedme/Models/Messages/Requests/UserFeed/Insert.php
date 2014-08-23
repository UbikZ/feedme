<?php

namespace Feedme\Models\Messages\Requests\UserFeed;

use Feedme\Models\Messages\Requests\Base;

class Insert extends Base
{
    /** @var  int */
    public $idUser;
    /** @var  int */
    public $idFeed;
    /** @var  boolean */
    public $subscribe;
    /** @var  boolean */
    public $like;
}
