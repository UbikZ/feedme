<?php

namespace Feedme\Models\Entities;

class FeedItem extends EntityAbstract
{
    private $userFeedItem = 'Feedme\\Models\\Entities\\UserFeedItem';
    private $feed = 'Feedme\\Models\\Entities\\Feed';

    /** @var  int */
    protected $idFeed;
    /** @var  string */
    protected $idHashed;
    /** @var  string */
    protected $title;
    /** @var  string */
    protected $categories;
    /** @var  string */
    protected $authorName;
    /** @var  string */
    protected $authorUri;
    /** @var  string */
    protected $link;
    /** @var  \DateTime */
    protected $adddate;
    /** @var  \DateTime */
    protected $changedate;
    /** @var  string */
    protected $summary;
    /** @var  string */
    protected $extract;
    /** @var  int */
    protected $countView;

    public function initialize()
    {
        parent::initialize();

        $this->belongsTo('idFeed', $this->feed, 'id');
        $this->hasMany('id', $this->userFeedItem, 'idFeedItem');
    }

    /**
     * @return int
     */
    public function countFavorites()
    {
        return $this->getRelated($this->userFeedItem);
    }

    /**
     * @return int
     */
    public function countLikes()
    {
        return $this->getRelated($this->userFeedItem);
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
     * @param string $idHashed
     */
    public function setIdHashed($idHashed)
    {
        $this->idHashed = $idHashed;
    }

    /**
     * @return string
     */
    public function getIdHashed()
    {
        return $this->idHashed;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorUri
     */
    public function setAuthorUri($authorUri)
    {
        $this->authorUri = $authorUri;
    }

    /**
     * @return string
     */
    public function getAuthorUri()
    {
        return $this->authorUri;
    }

    /**
     * @param string $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return string
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \DateTime $changedate
     */
    public function setChangedate($changedate)
    {
        $this->changedate = $changedate;
    }

    /**
     * @return \DateTime
     */
    public function getChangedate()
    {
        return $this->changedate;
    }

    /**
     * @param int $countView
     */
    public function setCountView($countView)
    {
        $this->countView = $countView;
    }

    /**
     * @return int
     */
    public function getCountView()
    {
        return $this->countView;
    }

    /**
     * @param string $extract
     */
    public function setExtract($extract)
    {
        $this->extract = $extract;
    }

    /**
     * @return string
     */
    public function getExtract()
    {
        return json_decode($this->extract);
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
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getSerializable($base = false, $options = array())
    {
        $return = parent::getSerializable($base);
        $return['extract'] = $this->getExtract();

        return $return;
    }
}
