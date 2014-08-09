<?php

namespace Feedme\Session;

class Handler
{
    public static function push(&$session, $name, $element)
    {
        $currentEls = array();
        if ($session->has($name)) {
            if (is_array($session->get($name))) {
                $currentEls = $session->get($name);
            } else {
                $currentEls = array($session->get($name));
            }
        }

        if (is_array($element)) {
            $currentEls = array_merge($currentEls, $element);
        } else {
            $currentEls[] = $element;
        }

        $session->set($name, $currentEls);
    }
}
