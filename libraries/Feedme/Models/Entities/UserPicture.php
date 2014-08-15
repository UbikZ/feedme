<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Url;

class UserPicture extends \Phalcon\Mvc\Model
{
    /** @var  int */
    protected $id;
    /** @var  string */
    protected $path;
    /** @var  string */
    protected $description;
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
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function getSerializable()
    {
        $result = array();
        $_allowed = array('id', 'path', 'description', 'active');
        foreach ($this as $propName => $propValue) {
            if (in_array($propName, $_allowed)) {
                $result[$propName] = $propValue;
            }
        }

        return $result;
    }
}
