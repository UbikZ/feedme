<?php

namespace Feedme\Models\Messages\Filters\UserFeed;

use Feedme\Models\Messages\Filters\Base;

class Select extends Base
{
    /** @var  int */
    public $idUser;
    /** @var int */
    public $idFeed;
    /** @var  boolean */
    public $subscribe;
    /** @var  boolean */
    public $like;
}
