<?php

class AbstractController extends Phalcon\Mvc\Controller
{

    protected function initialize()
    {
        Phalcon\Tag::prependTitle('Feedme | ');
        $this->view->auth = $this->session->get('auth');
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);

        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1]
            )
        );
    }

    protected function _hasIdentity()
    {
        return !is_null($this->session->get('auth'));
    }

    protected function _getIdentity()
    {
        return $this->session->get('auth');
    }
}
