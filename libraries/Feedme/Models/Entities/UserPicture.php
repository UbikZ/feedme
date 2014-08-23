<?php

namespace Feedme\Models\Entities;

class UserPicture extends EntityAbstract
{
    /** @var  string */
    protected $path;
    /** @var  string */
    protected $description;

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

    public function getSerializable($pbBase = false)
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
