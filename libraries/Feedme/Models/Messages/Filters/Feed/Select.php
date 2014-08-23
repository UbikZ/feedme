<?php

namespace Feedme\Models\Messages\Filters\Feed;

use Feedme\Models\Messages\Filters\Base;

class Select extends Base
{
    /** @var  int */
    public $idCreator;
    /** @var  int */
    public $type;
    /** @var  array */
    public $validate;
    /** @var  boolean */
    public $public;
    /** @var  string */
    public $needle;
}
