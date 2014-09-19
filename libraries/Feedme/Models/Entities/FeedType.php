<?php

namespace Feedme\Models\Entities;

class FeedType extends EntityAbstract
{
    /** @var  string */
    protected $label;
    /** @var  string */
    protected $class;

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('id', self::FEED, 'type');
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
