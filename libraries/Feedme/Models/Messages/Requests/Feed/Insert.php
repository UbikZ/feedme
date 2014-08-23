<?php

namespace Feedme\Models\Messages\Requests\Feed;

use Feedme\Models\Messages\Requests\Base;

class Insert extends Base
{
    /** @var  int */
    public $idCreator;
    /** @var  string */
    public $url;
    /** @var  string */
    public $label;
    /** @var  string */
    public $description;
    /** @var  int */
    public $type;
    /** @var  boolean */
    public $public;
}
