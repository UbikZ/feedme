<?php

namespace controllers;

use Phalcon\Tag;

class ErrorController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('authentication');
        parent::initialize();
    }

    public function notfoundAction()
    {
        Tag::setTitle('404 Error');
        $this->response->setStatusCode(404, 'Not Found');
    }

    public function internalerrorAction()
    {
        Tag::setTitle('500 Error');
        $this->response->setStatusCode(500, 'Internal Error');
    }
}
