<?php

namespace Feedme\Models\Messages;

use Phalcon\Mvc\Model\MessageInterface;

class DalMessage
{
    /** @var bool */
    protected $_success = false;
    /** @var MessageInterface[]  */
    protected $_errorMessages = array();

    /**
     * @param MessageInterface $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->_errorMessages[] = $errorMessage;
    }

    /**
     * @param MessageInterface[] $errorMessages
     */
    public function setErrorMessages($errorMessages)
    {
        $this->_errorMessages = $errorMessages;
    }

    /**
     * @return MessageInterface[]
     */
    public function getErrorMessages()
    {
        return $this->_errorMessages;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->_success = $success;
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->_success;
    }

    public function __toString()
    {
        $return = '';

        foreach ($this->getErrorMessages() as $message) {
            $return .= "Message: " . $message->getMessage() . " / ";
            $return .= "Field: " . $message->getField() . " / ";
            $return .= "Type: " . $message->getType();

        }

        return $return;
    }
}
