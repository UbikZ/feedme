<?php

namespace Feedme\Models\Entities;

class UserFeedItem extends EntityAbstract
{
    private $_user = 'Feedme\\Models\\Entities\\User';
    private $_feedItem = 'Feedme\\Models\\Entities\\FeedItem';

    /** @var  int */
    protected $idUser;
    /** @var  int */
    protected $idFeedItem;
    /** @var  boolean */
    protected $seen;
    /** @var  boolean */
    protected $like;

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('idUser', $this->_user, 'id');
        $this->belongsTo('idFeedItem', $this->_feedItem, 'id');
    }

    /**
     * @param boolean $seen
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
    }

    /**
     * @return boolean
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param int $idFeedItem
     */
    public function setIdFeedItem($idFeedItem)
    {
        $this->idFeedItem = $idFeedItem;
    }

    /**
     * @return int
     */
    public function getIdFeedItem()
    {
        return $this->idFeedItem;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param boolean $like
     */
    public function setLike($like)
    {
        $this->like = $like;
    }

    /**
     * @return boolean
     */
    public function getLike()
    {
        return $this->like;
    }
}
