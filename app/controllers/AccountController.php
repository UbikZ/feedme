<?php

use Feedme\Models\Services\Service;
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
        $identity = ($id ? $id : $this->_getIdentity()['id']);
        if (!$identity) {
            $this->notFoundAction();
        }
        /** @var User|bool $user */
        $user = Service::getService('User')->findFirstById($identity);
        if (!$user) {
            $this->notFoundAction();
        }

        if ($this->request->isPost()) {
            $postId = $this->request->getPost('id', 'int');
            // Secure update (exept for admin)
            if ($id != $identity || !$this->_isAdmin()) {
                $this->notFoundAction();
            }

            if (!Service::getService('User')->update($id, $this->request)) {
                $this->flash->error("Fail during update");
            } else {
                $this->flash->success("User was updated successfully");
            }
        }

        $this->view->setVar("name", array("main" => "Account", "sub" => "Profile"));
        $this->view->setVar("user", $user);

        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }
}
