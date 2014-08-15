<?php

namespace Feedme\Models\Messages\Requests\User;

class Update
{
    /** @var  int */
    public $id;
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
    /** @var  boolean */
    public $active;
    /** @var  int */
    public $picture;
}
