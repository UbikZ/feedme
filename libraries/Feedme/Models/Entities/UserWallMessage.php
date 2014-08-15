<?php

namespace Feedme\Models\Entities;

class UserWallMessage extends \Phalcon\Mvc\Model
{
    private $_user = 'Feedme\\Models\\Entities\\User';
    private $_userWall = 'Feedme\\Models\\Entities\\UserWall';

    /** @var  int */
    protected $id;
    /** @var  int */
    protected $idMessageSrc;

    /** @var  int */
    protected $idUserSrc;
    /** @var  string */
    protected $message;
    /** @var  \DateTime */
    protected $adddate;

    public function initialize()
    {
        $this->hasMany('id', get_class($this), 'idMessageSrc');
        $this->hasOne('idUserSrc', $this->_user, 'id');
        $this->hasManyToMany(
            'id',
            $this->_userWall,
            'idMessage',
            'idUser',
            $this->_user,
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
        return $this->getRelated($this->_user, $parameters);
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

    public function getSerializable($bBase = false)
    {
        $result = array();
        $_allowed = array('id', 'message', 'adddate');
        foreach ($this as $propName => $propValue) {
            if (in_array($propName, $_allowed)) {
                if ('adddate' === $propName) {
                    $result[$propName] =  (new \DateTime($propValue))->format('H\hi Y-m-d');
                } else {
                    $result[$propName] = $propValue;
                }
            }
        }
        $result['user'] = $this->getUserSrc()->getSerializable(true);
        $result['answers'] = array();
        if (!$bBase) {
            /** @var UserWallMessage $message */
            foreach ($this->getAnswers() as $message) {
                $result['answers'][] = $message->getSerializable(true);
            }

            // todo: clean dat dirty thing
            usort($result['answers'], function ($a, $b) {
                $tsA = date_create_from_format('H\hi Y-m-d', $a['adddate'])->getTimestamp();
                $tsB = date_create_from_format('H\hi Y-m-d', $b['adddate'])->getTimestamp();

                return ($tsA == $tsB) ? 0 : (($tsA < $tsB) ? 1 : -1);
            });
        }

        return $result;
    }
}
