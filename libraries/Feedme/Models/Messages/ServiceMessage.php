<?php

namespace Feedme\Models\Messages;

class ServiceMessage
{
    /** @var bool  */
    protected $_success = false;
    /** @var array  */
    protected $_errors = array();
    /** @var null|mixed  */
    protected $_message = null;

    /**
     * @param $error
     */
    public function setError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->_errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return implode(PHP_EOL, $this->_errors);
    }

    /**
     * @param mixed|null $message
     */
    public function setMessage($message)
    {
        $this->_message = $message;
    }

    /**
     * @return mixed|null
     */
    public function getMessage()
    {
        return $this->_message;
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
