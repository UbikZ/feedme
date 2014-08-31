<?php

namespace Feedme\Models\Messages\Filters\FeedItem;

use Feedme\Models\Messages\Filters\Base;

class Select extends Base
{
    /** @var  int */
    public $idFeed;
    /** @var  string */
    public $idHashed;
    /** @var  string */
    public $categories;
    /** @var  string */
    public $authorName;
    /** @var  string */
    public $adddate;
}
