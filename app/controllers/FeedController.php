<?php

use Phalcon\Mvc\View;

class FeedController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('feed');
        Phalcon\Tag::setTitle('Dashboard');
        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function newAction()
    {
        $this->view->setVar("name", array("main" => "Feed", "sub" => "Manage"));
    }
}
