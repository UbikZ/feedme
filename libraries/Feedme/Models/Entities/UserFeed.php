<?php

namespace Feedme\Models\Entities;

class UserFeed extends EntityAbstract
{
    private $_user = 'Feedme\\Models\\Entities\\User';
    private $_feed = 'Feedme\\Models\\Entities\\Feed';

    /** @var  int */
    protected $idUser;
    /** @var  int */
    protected $idFeed;
    /** @var  boolean */
    protected $subscribe;
    /** @var  boolean */
    protected $like;

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('idUser', $this->_user, 'id');
        $this->belongsTo('idFeed', $this->_feed, 'id');
    }

    /**
     * @param boolean $subscribe
     */
    public function setSubscribe($subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     * @return boolean
     */
    public function getSubscribe()
    {
        return filter_var($this->subscribe, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param int $idFeed
     */
    public function setIdFeed($idFeed)
    {
        $this->idFeed = $idFeed;
    }

    /**
     * @return int
     */
    public function getIdFeed()
    {
        return $this->idFeed;
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
        return filter_var($this->like, FILTER_VALIDATE_BOOLEAN);
    }
}
