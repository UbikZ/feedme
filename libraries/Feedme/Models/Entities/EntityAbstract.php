<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model;

abstract class EntityAbstract extends Model implements EntityInterface
{
    /** @var  array */
    protected $allowFields;

    /** @var  int */
    protected $id;
    /** @var  boolean */
    protected $active;

    public function initialize()
    {
        foreach ($this as $propName => $propValue) {
            if ($propName != 'allowFields') {
                $this->allowFields[] = $propName;
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
            if (is_array($this->allowFields)) {
                if (in_array($propName, $this->allowFields) &&
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
     * @param int $identity
     */
    public function setId($identity)
    {
        $this->id = $identity;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
