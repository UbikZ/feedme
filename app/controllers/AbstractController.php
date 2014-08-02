<?php

class AbstractController extends Phalcon\Mvc\Controller
{

    protected function initialize()
    {
        Phalcon\Tag::prependTitle('Feedme | ');
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
}
