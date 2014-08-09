<?php

use Feedme\Com\Notification\Alert;
use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\Requests\User\Update;
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

        /** @var ServiceMessage $findUserMsg */
        $findUserMsg = Service::getService('User')->findFirst($query);

        if ($findUserMsg->getSuccess()) {
            /** @var User $user */
            $user = $findUserMsg->getMessage();
            if ($this->request->isPost()) {

                // Build update request object
                $request = new Update();
                $request->id = $id;
                $request->firstname = $this->request->getPost('firstname');
                $request->lastname = $this->request->getPost('lastname');
                $request->username = $this->request->getPost('username');
                $request->password = $this->request->getPost('password');

                /** @var ServiceMessage $updateUserMsg */
                $updateUserMsg = Service::getService('User')->update($request);

                if ($updateUserMsg->getSuccess()) {
                    // Account changed == Connected user
                    if ($id == $this->_getIdentity()['id']) {
                        HandlerSession::push($this->session, 'auth', array(
                            "id" => $user->getId(),
                            "firstname" => $user->getFirstname(),
                            "lastname" => $user->getLastname(),
                            "bAdmin" => $user->getAdmin()
                        ));
                    }
                    HandlerSession::push($this->session, 'alerts', new Alert(
                        "Your account've been updated successfully",
                        Alert::LV_INFO
                    ));
                    $this->forward('/');

                } else {
                    HandlerSession::push(
                        $this->session,
                        'alerts',
                        new Alert($updateUserMsg->getErrors(), Alert::LV_ERROR)
                    );
                }
            }

            $this->view->setVar("name", array("main" => "Account", "sub" => "Profile"));
            $this->view->setVar("user", $user);

            $this->view->disableLevel(View::LEVEL_LAYOUT);
        } else {
            $this->notFoundAction();
        }
    }
}
