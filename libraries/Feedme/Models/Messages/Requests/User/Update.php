<?php

namespace Feedme\Models\Messages\Requests\User;

use Feedme\Models\Messages\Requests\Base;

class Update extends Base
{
    /** @var  string */
    public $firstname;
    /** @var  string */
    public $lastname;
    /** @var  string */
    public $username;
    /** @var  string */
    public $password;
    /** @var  boolean */
    public $admin;
    /** @var  string */
    public $society;
    /** @var  string */
    public $address;
    /** @var  string */
    public $about;
    /** @var  int */
    public $picture;
    /** @var  string */
    public $wallPicture;
}
