<?php

namespace Feedme\Models\Messages\Requests\UserWallMessage;

class Insert
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
