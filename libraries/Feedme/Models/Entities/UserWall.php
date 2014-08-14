<?php

namespace Feedme\Models\Entities;

class UserWall extends \Phalcon\Mvc\Model
{
    private $_user = 'Feedme\\Models\\Entities\\User';
    private $_userWall = 'Feedme\\Models\\Entitiers\\UserWallMessage';

    /** @var  int */
    protected $idUser;
    /** @var  int */
    protected $idMessage;
    /** @var  boolean */
    protected $active;

    public function initialize()
    {
        $this->belongsTo('idUser', $this->_user, 'id');
        $this->belongsTo('idMessage', $this->_userWall, 'id');
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
     * @param int $idMessage
     */
    public function setIdMessage($idMessage)
    {
        $this->idMessage = $idMessage;
    }

    /**
     * @return int
     */
    public function getIdMessage()
    {
        return $this->idMessage;
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
}
