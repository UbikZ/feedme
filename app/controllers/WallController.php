<?php

use Phalcon\Mvc\View;

class WallController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('dashboard');
        Phalcon\Tag::setTitle('Dashboard');
        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function indexAction()
    {
        $this->view->setVar("name", array("main" => "Profile", "sub" => "Wall"));
    }
}
