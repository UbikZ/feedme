<?php

namespace controllers;

use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class AbstractController extends Controller
{
    /** @var User */
    protected $currentUser = null;
    /** @var array  */
    protected $errors = array();

    protected function initialize()
    {
        Tag::prependTitle('Feedme | ');
        $this->view->setVar('errors', $this->getIdentity());
        if ($this->hasIdentity()) {
            $query = new Select();
            $query->id =  $this->getIdentity()['id'];
            /** @var ServiceMessage $findUserMsg */
            $findUserMsg = Service::getService('User')->find($query);

            if ($findUserMsg->getSuccess()) {
                $this->currentUser = $findUserMsg->getMessage();
                $this->view->setVar('currentUser', $this->currentUser);
            }
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        $this->view->setVar('errors', $this->errors);
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
        Tag::setTitle('404 Error');
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('error/not-found');
    }

    public function internalErrorAction()
    {
        $this->view->setTemplateAfter('authentication');
        Tag::setTitle('500 Error');
        $this->response->setStatusCode(500, 'Internal Error');
        $this->view->pick('error/internal-error');
    }

    protected function isAdmin()
    {
        return (bool) $this->getIdentity()['bAdmin'];
    }

    protected function hasIdentity()
    {
        return !is_null($this->getIdentity());
    }

    protected function getIdentity()
    {
        return $this->session->get('auth');
    }
}
