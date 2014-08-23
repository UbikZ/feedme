<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model;

abstract class EntityAbstract extends Model implements EntityInterface
{
    /** @var  int */
    protected $id;
    /** @var  boolean */
    protected $active;

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

    /**
     * @param  bool  $pbBase
     * @return mixed
     */
    public function getSerializable($pbBase = false)
    {
        // TODO: Implement getSerializable() method.
    }
}
