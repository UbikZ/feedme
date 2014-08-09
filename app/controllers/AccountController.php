<?php

use Feedme\Com\Notification\Alert;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\ServiceMessage;
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

        $query = new Select();
        $query->id = $id;
        /** @var User|bool $user */
        /** @var ServiceMessage $message */
        $message = Service::getService('User')->findFirstById($id);

        // todo ===>
        if ($message->getSuccess()) {

        } else {

        }

        if (!$user) {
            $this->notFoundAction();
        }
        if ($this->request->isPost()) {
            // Secure update (exept for admin)

            $return = Service::getService('User')->update($id, $this->request);

            if (!$return) {
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
            die;
            $this->forward('/');
        }

        $this->view->setVar("name", array("main" => "Account", "sub" => "Profile"));
        $this->view->setVar("user", $user);

        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }
}
