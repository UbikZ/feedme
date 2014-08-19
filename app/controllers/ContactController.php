<?php

use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Mvc\View;

class ContactController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('contact');
        Phalcon\Tag::setTitle('Dashboard');
        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function listAction()
    {
        /** @var ServiceMessage $findUserMsg */
        $findUserMsg = Service::getService('User')->find(new Select());
        /** @var Simple $users */
        $users = $findUserMsg->getMessage();
        if ($findUserMsg->getSuccess()) {
            $this->view->setVar('users', $users);
            $this->view->setVar("name", array("main" => "Contacts", "sub" => "List"));
        } else {
            $this->internalErrorAction();
        }
    }
}