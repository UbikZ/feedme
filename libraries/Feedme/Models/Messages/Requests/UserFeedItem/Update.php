<?php

namespace Feedme\Models\Messages\Requests\UserFeedItem;

use Feedme\Models\Messages\Requests\Base;

class Update extends Base
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
