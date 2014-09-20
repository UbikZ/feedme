<?php

namespace controllers;

use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\View;
use Phalcon\Tag;

class ContactController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('contact');
        Tag::setTitle('Dashboard');
        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function listAction()
    {
        /** @var ServiceMessage $findUserMsg */
        $findUserMsg = Service::getService('User')->find(new Select());
        /** @var Simple $users */
        $users = $findUserMsg->getMessage();
        if ($findUserMsg->getSuccess()) {
            $this->view->setVar('users', ($users->count() == 1) ? array($users) : $users);
            $this->view->setVar("name", array("main" => "Contacts", "sub" => "List"));
        } else {
            $this->internalError();
        }
    }
}
