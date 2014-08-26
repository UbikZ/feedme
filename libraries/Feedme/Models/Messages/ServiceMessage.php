<?php

namespace Feedme\Models\Messages;

class ServiceMessage
{
    /** @var bool  */
    protected $_success = false;
    /** @var array  */
    protected $errors = array();
    /** @var null|mixed  */
    protected $_message = null;

    /**
     * @param $error
     */
    public function setError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getErrors()
    {
        return implode(PHP_EOL, $this->errors);
    }

    /**
     * @return array
     */
    public function getErrorsArray()
    {
        return $this->errors;
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
