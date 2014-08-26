<?php

namespace Feedme\Models\Entities;

class UserWall extends EntityAbstract

{
    private $user = 'Feedme\\Models\\Entities\\User';
    private $userWall = 'Feedme\\Models\\Entitiers\\UserWallMessage';

    /** @var  int */
    protected $idUser;
    /** @var  int */
    protected $idMessage;

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('idUser', $this->user, 'id');
        $this->belongsTo('idMessage', $this->userWall, 'id');
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
