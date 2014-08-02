<?php

class IndexController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('authentication');
        Phalcon\Tag::setTitle('Authentication');
        parent::initialize();
    }

    public function indexAction()
    {

    }
}
