<?php

namespace Feedme\Models\Entities;

class UserPicture extends EntityAbstract
{
    /** @var  string */
    protected $path;
    /** @var  string */
    protected $description;

    public function initialize()
    {
        parent::initialize();
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
}
