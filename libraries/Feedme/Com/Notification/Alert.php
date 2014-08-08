<?php

namespace Feedme\Com\Notification;

class Alert
{
    const LV_INFO = 1;
    const LV_WARNING = 2;
    const LV_ERROR = 3;

    /** @var  int */
    protected $_level;
    /** @var  string */
    protected $_message;
    /** @var  \DateTime */
    protected $_datetime;

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->_datetime = $datetime;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->_datetime;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->_level = $level;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->_level;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->_message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    public function __construct($message, $level = self::LV_INFO)
    {
        $this->setLevel($level);
        $this->setMessage($message);
        $this->setDatetime(new \DateTime());
    }

}
