<?php

namespace Feedme\Models\Entities;

use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Validator\Url;

class Feed extends EntityAbstract
{
    // Foreign keys
    private $userFK = 'Feedme\\Models\\Entities\\User';
    private $userFeedFK = 'Feedme\\Models\\Entities\\UserFeed';
    private $feedItemFK = 'Feedme\\Models\\Entities\\FeedItem';
    private $feedTypeFK = 'Feedme\\Models\\Entities\\FeedType';

    /** @var  int */
    protected $idCreator;
    /** @var  string */
    protected $url;
    /** @var  string */
    protected $label;
    /** @var  string */
    protected $description;
    /** @var  int */
    protected $type;
    /** @var  \DateTime */
    protected $adddate;
    /** @var  string */
    protected $validate;
    /** @var  boolean */
    protected $public;

    public function initialize()
    {
        parent::initialize();

        $this->hasOne('type', $this->feedTypeFK, 'id');
        $this->hasOne('idCreator', $this->userFK, 'id');
        $this->hasMany('id', $this->feedItemFK, 'idFeed');
        $this->hasMany('id', $this->userFeedFK, 'idFeed');
    }

    /**
     * @return FeedType
     */
    public function getFeedType()
    {
        return $this->getRelated($this->feedTypeFK);
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->getRelated($this->userFK);
    }

    /**
     * @return FeedItem
     */
    public function getFeedItems()
    {
        return $this->getRelated($this->feedItemFK);
    }

    /**
     * @param $idUser
     * @return UserFeed
     */
    public function getUserFeed($idUser)
    {
        $result = new UserFeed();
        $result->setSubscribe('0');
        $result->setLike('0');
        if (is_numeric($idUser)) {
            /** @var UserFeed $result */
            $return = $this->getRelated($this->userFeedFK, "[idUser]=" . intval($idUser))->getFirst();
            if ($return) {
                $result = $return;
            }
        }

        return $result;
    }

    /**
     * @return int
     */
    public function countLikes()
    {
        /** @var Resultset\Simple $userFeed */
        $userFeed = $this->getRelated($this->userFeedFK, "[like]='1'");

        return $userFeed->count();
    }

    /**
     * @return int
     */
    public function countSubscribes()
    {
        /** @var UserFeed $userFeed */
        $userFeed = $this->getRelated($this->userFeedFK, "[subscribe]='1'");

        return $userFeed->count();
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
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
     * @param string $validate
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;
    }

    /**
     * @return string
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param int $idCreator
     */
    public function setIdCreator($idCreator)
    {
        $this->idCreator = $idCreator;
    }

    /**
     * @return int
     */
    public function getIdCreator()
    {
        return $this->idCreator;
    }

    /**
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function validation()
    {
        $this->validate(
            new Url(
                array(
                    "field" => "url",
                    "required" => true,
                )
            )
        );

        return !$this->validationHasFailed();
    }

    public function getSerializable($pbBase = false, $options = array())
    {
        $result = parent::getSerializable($pbBase, $options);
        $result['countSubscribes'] = $this->countSubscribes();
        $result['countLikes'] = $this->countLikes();

        if (!$pbBase) {
            $result['feedType'] = $this->getFeedType()->getSerializable(true);
            $result['creator'] = $this->getCreator()->getSerializable(true);
            if (isset($options['idUser'])) {
                $result['userFeed'] = $this->getUserFeed($options['idUser'])->getSerializable(true);
            }
        }

        return $result;
    }
}
