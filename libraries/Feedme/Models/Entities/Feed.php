<?php

namespace Feedme\Models\Entities;

class Feed extends \Phalcon\Mvc\Model
{
    // Foreign keys
    private $_userFK = 'Feedme\\Models\\Entities\\User';
    private $_userFeedFK = 'Feedme\\Models\\Entities\\UserFeed';
    private $_feedItemFK = 'Feedme\\Models\\Entities\\FeedItem';
    private $_feedTypeFK = 'Feedme\\Models\\Entities\\FeedType';

    /** @var  int */
    protected $id;
    /** @var  int */
    protected $idCreator;
    /** @var  string */
    protected $url;
    /** @var  string */
    protected $description;
    /** @var  int */
    protected $type;
    /** @var  \DateTime */
    protected $adddate;
    /** @var  boolean */
    protected $active;
    /** @var  boolean */
    protected $public;

    public function initialize()
    {
        $this->hasOne('type', $this->_feedTypeFK, 'id');
        $this->hasOne('idCreator', $this->_userFK, 'id');
        $this->hasMany('id', $this->_feedItemFK, 'idFeed');
        $this->hasMany('id', $this->_userFeedFK, 'idFeed');
    }

    /**
     * @return FeedType
     */
    public function getFeedType()
    {
        return $this->getRelated($this->_feedTypeFK);
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->getRelated($this->_userFK);
    }

    /**
     * todo : get only active feeds
     * @return FeedItem
     */
    public function getFeedItems()
    {
        return $this->getRelated($this->_feedItemFK);
    }

    /**
     * @return int
     */
    public function countFavorites()
    {
        return $this->getRelated($this->_userFeedFK);
    }

    /**
     * @return int
     */
    public function countLikes()
    {
        return $this->getRelated($this->_userFeedFK);
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
     * @param \DateTime $adddate
     */
    public function setAdddate($adddate)
    {
        $this->adddate = $adddate;
    }

    /**
     * @return \DateTime
     */
    public function getAdddate()
    {
        return $this->adddate;
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
     * @param int $idCreator
     */
    public function setIdCreator($idCreator)
    {
        $this->idCreator = $idCreator;
    }

    /**
     * @return int
     */
    public function getIdCreator()
    {
        return $this->idCreator;
    }

    /**
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
