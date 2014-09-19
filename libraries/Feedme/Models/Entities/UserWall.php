<?php

namespace Feedme\Models\Entities;

class UserWall extends EntityAbstract
{
    /** @var  int */
    protected $idUser;
    /** @var  int */
    protected $idMessage;

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('idUser', self::USER, 'id');
        $this->belongsTo('idMessage', self::USER_WALL, 'id');
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
