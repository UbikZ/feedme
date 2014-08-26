<?php

namespace Feedme\Models\Messages;

use Phalcon\Mvc\Model\MessageInterface;

class DalMessage
{
    /** @var bool */
    protected $success = false;
    /** @var MessageInterface[]  */
    protected $errorMessages = array();

    /**
     * @param MessageInterface $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessages[] = $errorMessage;
    }

    /**
     * @param MessageInterface[] $errorMessages
     */
    public function setErrorMessages($errorMessages)
    {
        $this->errorMessages = $errorMessages;
    }

    /**
     * @return MessageInterface[]
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
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
