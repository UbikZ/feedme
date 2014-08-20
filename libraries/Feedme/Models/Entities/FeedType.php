<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model;

class FeedType extends Model
{
    private $_feed = 'Feedme\\Models\\Entities\\Feed';

    /** @var  int */
    protected $id;
    /** @var  string */
    protected $label;
    /** @var  string */
    protected $class;
    /** @var  boolean */
    protected $active;

    public function initialize()
    {
        $this->belongsTo('id', $this->_feed, 'type');
    }
    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
