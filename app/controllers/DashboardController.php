<?php

class DashboardController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('dashboard');
        Phalcon\Tag::setTitle('Dashboard');
        parent::initialize();
    }

    public function indexAction()
    {
        /** @var \Feedme\Models\Entities\User $user */
        $user = $this->session->get('user');

        $this->view->setVar("firstname", $user->getFirstname());
        $this->view->setVar("lastname", $user->getLastname());
    }
}
