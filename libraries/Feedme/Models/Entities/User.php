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

    /** @var  string */
    protected $society;

    /** @var  string */
    protected $address;

    /** @var  string */
    protected $about;

    /** @var  string */
    protected $profilePicture;

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
        $this->hasMany('id', $this->_userWallMessagePK, 'idUserSrc');
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
     * @param  null            $parameters
     * @return UserWallMessage
     */
    public function getAllMessages($parameters = null)
    {
        return $this->getRelated($this->_userWallMessagePK, $parameters);
    }

    /**
     * @param int $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return File
     */
    public function getWallPicture()
    {
        return new File($this->getProfilePicture());
    }

    /**
     * @param string $about
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @return int
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param string $society
     */
    public function setSociety($society)
    {
        $this->society = $society;
    }

    /**
     * @return string
     */
    public function getSociety()
    {
        return $this->society;
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

    public function getSerializable($bBase = false)
    {
        $result = array();
        $_allowed =
            array('id', 'firstname', 'lastname', 'username', 'email', 'password', 'datetime', 'admin', 'active');
        foreach ($this as $propName => $propValue) {
            if (in_array($propName, $_allowed)) {
                $result[$propName] = $propValue;
            }
        }
        $result['picture'] = $this->getUserPicture()->getSerializable();
        if (!$bBase) {
            $result['messages'] = array();

            /** @var UserWallMessage $message */
            foreach ($this->messages as $message) {
                $result['messages'][] = $message->getSerializable();
            }
            // todo: clean dat dirty thing
            usort($result['messages'], function ($a, $b) {
                $tsA = date_create_from_format('H\hi Y-m-d', $a['adddate'])->getTimestamp();
                $tsB = date_create_from_format('H\hi Y-m-d', $b['adddate'])->getTimestamp();

                return ($tsA == $tsB) ? 0 : (($tsA < $tsB) ? 1 : -1);
            });
        }

        return $result;
    }
}
