<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model\Validator\Email as Email;

class User extends \Phalcon\Mvc\Model
{
    // Foreign key
    private $_userPictureFK = 'Feedme\\Models\\Entities\\UserPicture';
    private $_userWallPK = 'Feedme\\Models\\Entities\\UserWall';
    private $_userWallMessagePK = 'Feedme\\Models\\Entities\\UserWallMessage';

    /** @var  int */
    protected $id;

    /** @var  string */
    protected $firstname;

    /** @var  string */
    protected $lastname;

    /** @var  string */
    protected $username;

    /** @var  string */
    protected $email;

    /** @var  string */
    protected $password;

    /** @var  \DateTime */
    protected $datetime;

    /** @var  boolean */
    protected $admin;

    /** @var  boolean */
    protected $active;

    /** @var  int */
    protected $picture;

    /**
     *
     */
    public function initialize()
    {
        $this->hasOne('picture', $this->_userPictureFK, 'id');
        $this->hasManyToMany(
            'id',
            $this->_userWallPK,
            'idUser',
            'idMessage',
            $this->_userWallMessagePK,
            'id',
            array('alias' => 'messages')
        );
    }

    /**
     * @param  null        $parameters
     * @return UserPicture
     */
    public function getUserPicture($parameters = null)
    {
        return $this->getRelated($this->_userPictureFK, $parameters);
    }

    /**
     * @param int $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return int
     */
    public function getPicture()
    {
        return $this->picture;
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
     * @param boolean $isAdmin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return boolean
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
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
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Validations and business logic
     */
    public function validation()
    {

        $this->validate(
            new Email(
                array(
                    "field" => "email",
                    "required" => true,
                )
            )
        );

        return !$this->validationHasFailed();
    }

    public function getJson()
    {
        //todo
    }
}
