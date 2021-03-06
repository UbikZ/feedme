<?php

namespace Feedme\Models\Entities;

class UserWallMessage extends EntityAbstract
{
    /** @var  int */
    protected $idMessageSrc;

    /** @var  int */
    protected $idUserSrc;
    /** @var  string */
    protected $message;
    /** @var  string */
    protected $adddate;

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', get_class($this), 'idMessageSrc');
        $this->hasOne('idUserSrc', self::USER, 'id');
        $this->hasManyToMany(
            'id',
            self::USER_WALL,
            'idMessage',
            'idUser',
            self::USER,
            'id',
            array('alias' => 'users')
        );
    }

    /**
     * @param  null            $parameters
     * @return UserWallMessage
     */
    public function getAnswers($parameters = null)
    {
        return $this->getRelated(get_class($this), $parameters);
    }

    /**
     * @param  null $parameters
     * @return User
     */
    public function getUserSrc($parameters = null)
    {
        return $this->getRelated(self::USER, $parameters);
    }

    /**
     * @param string $adddate
     */
    public function setAdddate($adddate)
    {
        $this->adddate = $adddate;
    }

    /**
     * @return string
     */
    public function getAdddate()
    {
        return $this->adddate;
    }

    /**
     * @param int $idMessageSrc
     */
    public function setIdMessageSrc($idMessageSrc)
    {
        $this->idMessageSrc = $idMessageSrc;
    }

    /**
     * @return int
     */
    public function getIdMessageSrc()
    {
        return $this->idMessageSrc;
    }

    /**
     * @param int $idUserSrc
     */
    public function setIdUserSrc($idUserSrc)
    {
        $this->idUserSrc = $idUserSrc;
    }

    /**
     * @return int
     */
    public function getIdUserSrc()
    {
        return $this->idUserSrc;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function getSerializable($pbBase = false, $options = array())
    {
        $result = parent::getSerializable($pbBase, $options);

        $result['addate'] = (new \DateTime($this->getAdddate()))->format('H\hi Y-m-d');
        $result['user'] = $this->getUserSrc()->getSerializable(true);
        $result['answers'] = array();
        if (!$pbBase) {
            /** @var UserWallMessage $message */
            foreach ($this->getAnswers() as $message) {
                $result['answers'][] = $message->getSerializable(true);
            }
        }

        return $result;
    }
}
