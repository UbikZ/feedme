<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model;

class UserFeed extends Model
{
    private $_user = 'Feedme\\Models\\Entities\\User';
    private $_feed = 'Feedme\\Models\\Entities\\Feed';

    /** @var  int */
    protected $idUser;
    /** @var  int */
    protected $idFeed;
    /** @var  boolean */
    protected $favorite;
    /** @var  boolean */
    protected $like;

    public function initialize()
    {
        $this->belongsTo('idUser', $this->_user, 'id');
        $this->belongsTo('idFeed', $this->_feed, 'id');
    }

    /**
     * @param boolean $favorite
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;
    }

    /**
     * @return boolean
     */
    public function getFavorite()
    {
        return $this->favorite;
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
        return $this->like;
    }
}
