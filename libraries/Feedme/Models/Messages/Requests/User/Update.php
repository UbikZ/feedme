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
    /** @var  string */
    public $society;
    /** @var  string */
    public $address;
    /** @var  string */
    public $about;
    /** @var  boolean */
    public $active;
    /** @var  int */
    public $picture;
    /** @var  string */
    public $wallPicture;
}
