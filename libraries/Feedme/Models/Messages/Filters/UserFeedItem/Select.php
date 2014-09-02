<?php

namespace Feedme\Models\Messages\Filters\UserFeedItem;

use Feedme\Models\Messages\Filters\Base;

class Select extends Base
{
    /** @var  int */
    public $idUser;
    /** @var  int */
    public $idFeedItem;
    /** @var  bool */
    public $seen;
    /** @var  bool */
    public $like;
}
