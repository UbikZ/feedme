<?php

namespace Feedme\Com\Notification;

class Alert
{
    const LV_INFO = 1;
    const LV_WARNING = 2;
    const LV_ERROR = 3;

    /** @var  int */
    protected $level;
    /** @var  string */
    protected $message;
    /** @var  \DateTime */
    protected $datetime;

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
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
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

    public function __construct($message, $level = self::LV_INFO)
    {
        $this->setLevel($level);
        $this->setMessage($message);
        $this->setDatetime(new \DateTime());
    }

}
