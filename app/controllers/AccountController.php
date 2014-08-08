<?php

use Feedme\Com\Notification\Alert;
use Feedme\Models\Services\Service;
use Feedme\Session\Handler as HandlerSession;
use Phalcon\Mvc\View;

class AccountController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('dashboard');
        Phalcon\Tag::setTitle('Dashboard');
        parent::initialize();
    }

    public function indexAction()
    {

        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function editAction($id = null)
    {
        if (!$id && ($id != $this->_getIdentity()['id']) && !$this->_isAdmin()) {
            $this->notFoundAction();
        }
        //var_dump("int");die;
        /** @var User|bool $user */
        $user = Service::getService('User')->findFirstById($id);

        if (!$user) {
            $this->notFoundAction();
        }
        if ($this->request->isPost()) {
            $postId = $this->request->getPost('id', 'int');
            // Secure update (exept for admin)

            if (!Service::getService('User')->update($id, $this->request)) {
                HandlerSession::push($this->session, 'alerts', new Alert(
                    "An error occured while updating your account",
                    Alert::LV_ERROR
                ));
            } else {
                HandlerSession::push($this->session, 'alerts', new Alert(
                    "Your account've been updated successfully",
                    Alert::LV_INFO
                ));
            }
            $this->forward('/');
        }

        $this->view->setVar("name", array("main" => "Account", "sub" => "Profile"));
        $this->view->setVar("user", $user);

        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }
}
