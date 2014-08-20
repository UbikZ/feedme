<?php

use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;

class AbstractController extends Phalcon\Mvc\Controller
{
    /** @var User */
    protected $_currentUser = null;
    /** @var array  */
    protected $_errors = array();

    protected function initialize()
    {
        Phalcon\Tag::prependTitle('Feedme | ');
        $this->view->setVar('auth', $this->_getIdentity());
        $this->view->setVar('errors', $this->_getIdentity());
        if ($this->_hasIdentity()) {
            $query = new Select();
            $query->id =  $this->_getIdentity()['id'];
            /** @var ServiceMessage $findUserMsg */
            $findUserMsg = Service::getService('User')->find($query);

            if ($findUserMsg->getSuccess()) {
                $this->_currentUser = $findUserMsg->getMessage();
                $this->view->setVar('currentUser', $this->_currentUser);
            }
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        $this->view->setVar('errors', $this->_errors);
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);

        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1]
            )
        );
    }

    public function notFoundAction()
    {
        $this->view->setTemplateAfter('authentication');
        Phalcon\Tag::setTitle('404 Error');
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('error/not-found');
    }

    public function internalErrorAction()
    {
        $this->view->setTemplateAfter('authentication');
        Phalcon\Tag::setTitle('500 Error');
        $this->response->setStatusCode(500, 'Internal Error');
        $this->view->pick('error/internal-error');
    }

    protected function _isAdmin()
    {
        return (bool) $this->_getIdentity()['bAdmin'];
    }

    protected function _hasIdentity()
    {
        return !is_null($this->_getIdentity());
    }

    protected function _getIdentity()
    {
        return $this->session->get('auth');
    }

}
