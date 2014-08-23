<?php

namespace Feedme\Models\Messages\Filters\User;

use Feedme\Models\Messages\Filters\Base;

class Select extends Base
{
    /** @var  string */
    public $email;
    /** @var  string */
    public $password;
    /** @var  boolean */
    public $admin;
}
