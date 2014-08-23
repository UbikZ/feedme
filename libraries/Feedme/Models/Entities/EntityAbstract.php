<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model;

abstract class EntityAbstract extends Model implements EntityInterface
{
    /** @var  array */
    protected $_allowSerializabledFields;

    /** @var  int */
    protected $id;
    /** @var  boolean */
    protected $active;

    public function initialize()
    {
        foreach ($this as $propName => $propValue) {
            if ($propName != '_allowSerializabledFields') {
                $this->_allowSerializabledFields[] = $propName;
            }
        }
    }

    /**
     * @param  bool        $pbBase
     * @param  array       $options
     * @return array|mixed
     */
    public function getSerializable($pbBase = false, $options = array())
    {
        $result = array();

        foreach ($this as $propName => $propValue) {
            if (is_array($this->_allowSerializabledFields)) {
                if (in_array($propName, $this->_allowSerializabledFields) &&
                    preg_match('/^_/', $propName) == 0) {
                    $result[$propName] = $propValue;
                }
            }
        }

        return $result;
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
}
