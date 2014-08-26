<?php

namespace Feedme\Models\Messages\Filters;

abstract class Base
{
    /** @var  int */
    public $identity;
    /** @var  boolean */
    public $active;
    /** @var  int */
    public $connectedUserId;
    /** @var  int */
    public $limit;
    /** @var  string */
    public $order;
    /** @var  string */
    public $direction = 'DESC';
}
