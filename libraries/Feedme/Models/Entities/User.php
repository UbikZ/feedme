<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Paginator\Adapter\Model;

class User extends EntityAbstract
{
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
    /** @var  int */
    protected $picture;

    /**
     *
     */
    public function initialize()
    {
        parent::initialize();

        $this->hasOne('picture', self::USER_PICTURE, 'id');
        $this->hasMany('id', self::USER_WALL_MESSAGE, 'idUserSrc');
        $this->hasMany('id', self::USER_FEED, 'idUser');
        $this->hasManyToMany(
            'id',
            self::USER_WALL,
            'idUser',
            'idMessage',
            self::USER_WALL_MESSAGE,
            'id',
            array('alias' => 'messages')
        );
        $this->hasManyToMany(
            'id',
            self::USER_FEED_ITEM,
            'idUser',
            'idFeedItem',
            self::FEED_ITEM,
            'id'
        );
    }

    /**
     * @param  null        $parameters
     * @return UserPicture
     */
    public function getUserPicture($parameters = null)
    {
        return $this->getRelated(self::USER_PICTURE, $parameters);
    }

    /**
     * @param  null            $parameters
     * @return UserWallMessage
     */
    public function getAllMessages($parameters = null)
    {
        return $this->getRelated(self::USER_WALL_MESSAGE, $parameters);
    }

    /**
     * @return int
     */
    public function countLikedFeeds()
    {
        $return = 0;
        /** @var Simple $result */
        $result = $this->getRelated(self::USER_FEED, '[like] = \'1\'');
        if (false != $result) {
            $return = $result->count();
        }

        return $return;
    }

    /**
     * @return int
     */
    public function countViewedFeedItems()
    {
        $return = 0;
        /** @var Simple $result */
        $result = $this->getRelated(self::FEED_ITEM, 'seen = \'1\'');
        if (false != $result) {
            $return = $result->count();
        }

        return $return;
    }

    /**
     * @param  int   $page
     * @param  int   $limit
     * @return mixed
     */
    public function getFeedItems($page = 1, $limit = 10)
    {
        $items = $this->getRelated(self::FEED_ITEM, 'seen = \'0\'');
        $paginator = new Model(array('data' => $items, 'limit' => $limit, 'page' => $page));

        return $paginator->getPaginate()->items;
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

    public function getSerializable($pbBase = false, $options = array())
    {
        $result = parent::getSerializable($pbBase, $options);

        $result['picture'] = $this->getUserPicture()->getSerializable();
        if (!$pbBase) {
            $result['messages'] = array();

            /** @var UserWallMessage $message */
            foreach ($this->messages as $message) {
                $result['messages'][] = $message->getSerializable();
            }
            usort($result['messages'], function ($var1, $var2) {
                $tsA = date_create_from_format('H\hi Y-m-d', $var1['adddate'])->getTimestamp();
                $tsB = date_create_from_format('H\hi Y-m-d', $var2['adddate'])->getTimestamp();

                return ($tsA == $tsB) ? 0 : (($tsA < $tsB) ? 1 : -1);
            });
        }

        return $result;
    }
}
