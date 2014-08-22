<?php

namespace Feedme\Models\Messages\Requests\UserFeed;

class Insert
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
