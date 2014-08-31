<?php

namespace Feedme\Models\Messages\Requests\FeedItem;

use Feedme\Models\Messages\Requests\Base;

class Insert extends Base
{
    /** @var  int */
    public $idFeed;
    /** @var  string */
    public $idHashed;
    /** @var  string */
    public $title;
    /** @var  string */
    public $description;
    /** @var  array */
    public $categories;
    /** @var  string */
    public $authorName;
    /** @var  string */
    public $authorUri;
    /** @var  string */
    public $link;
    /** @var  \DateTime */
    public $adddate;
    /** @var  \DateTime */
    public $changedate;
    /** @var  array */
    public $extract;
}
