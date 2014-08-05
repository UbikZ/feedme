<?php

class IndexController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('authentication');
        Phalcon\Tag::setTitle('Authentication');
        parent::initialize();
        if ($this->_hasIdentity()) {
            $this->response->redirect('dashboard/index');
        }
    }

    public function indexAction()
    {

    }
}
