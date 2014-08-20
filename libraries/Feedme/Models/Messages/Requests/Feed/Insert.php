<?php

namespace Feedme\Models\Messages\Requests\Feed;

class Insert
{
    /** @var  int */
    public $idCreator;
    /** @var  string */
    public $url;
    /** @var  string */
    public $description;
    /** @var  int */
    public $type;
    /** @var  boolean */
    public $active;
    /** @var  boolean */
    public $public;
}
