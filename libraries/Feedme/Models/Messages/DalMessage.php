<?php

namespace Feedme\Models\Messages;

class DalMessage
{
    /** @var bool */
    protected $_success = false;
    /** @var array  */
    protected $_errorMessages = array();

    /**
     * @param $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->_errorMessages[] = $errorMessage;
    }

    /**
     * @param array $errorMessages
     */
    public function setErrorMessages($errorMessages)
    {
        $this->_errorMessages = $errorMessages;
    }

    /**
     * @return array
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
}