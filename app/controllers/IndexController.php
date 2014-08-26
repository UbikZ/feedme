<?php

namespace controllers;

use Phalcon\Tag;

class IndexController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('authentication');
        Tag::setTitle('Authentication');
        parent::initialize();
        if ($this->hasIdentity()) {
            $this->response->redirect('dashboard/index');
        }
    }

    public function indexAction()
    {

    }
}
