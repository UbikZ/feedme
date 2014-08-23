<?php

namespace Feedme\Models\Entities;

class FeedType extends EntityAbstract
{
    private $_feed = 'Feedme\\Models\\Entities\\Feed';

    /** @var  string */
    protected $label;
    /** @var  string */
    protected $class;

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('id', $this->_feed, 'type');
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
