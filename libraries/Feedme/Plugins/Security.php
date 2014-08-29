<?php

namespace Feedme\Plugins;

use Feedme\Com\Notification\Alert;
use Feedme\Session\Handler as HandlerSession;

use \Phalcon\Events\Event;
use \Phalcon\Mvc\User\Plugin;
use \Phalcon\Mvc\Dispatcher;
use \Phalcon\Acl;

class Security extends Plugin
{

    const GUESTS = 'guests';
    const USERS = 'users';
    const ADMINS = 'admins';

    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function getAcl()
    {
        if (!isset($this->persistent->acl)) {

            $acl = new \Phalcon\Acl\Adapter\Memory();

            $acl->setDefaultAction(\Phalcon\Acl::DENY);

            // Ressources
            $configurations = array(
                self::GUESTS => array(
                    'role' => new \Phalcon\Acl\Role(self::GUESTS),
                    'ressources' => array(
                        'index' => array('index'),
                        'session' => array('index', 'register', 'login', 'logout'),
                        'error' => array('notfound', 'internalerror')
                    )
                ),
                self::USERS => array(
                    'role' => new \Phalcon\Acl\Role(self::USERS),
                    'ressources' => array(
                        'index' => array('index'),
                        'dashboard' => array('index', 'profile'),
                        'wall' => array('profile', 'information', 'post', 'delete'),
                        'contact' => array('list'),
                        'feed' => array('new', 'list', 'post', 'refresh', 'load'),
                        'session' => array('logout'),
                        'account' => array('edit'),
                        'error' => array('notfound', 'internalerror')
                    )
                ),
                self::ADMINS => array(
                    'role' => new \Phalcon\Acl\Role(self::ADMINS),
                    'ressources' => array(
                        'index' => array('index'),
                        'admin' => array('index'),
                        'wall' => array('profile', 'information', 'post', 'delete'),
                        'contact' => array('list'),
                        'dashboard' => array('index', 'profile'),
                        'feed' => array('new', 'list', 'post', 'refresh', 'load'),
                        'session' => array('logout'),
                        'account' => array('edit'),
                        'error' => array('notfound', 'internalerror')
                    )
                )
            );

            // Register roles, ressources and grant/deny some rigths
            foreach ($configurations as $configuration) {
                $acl->addRole($role = $configuration["role"]);
                foreach ($configuration["ressources"] as $resource => $actions) {
                    $acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
                    foreach ($actions as $action) {
                        $acl->allow($role->getName(), $resource, $action);
                    }
                }
            }

            // The acl is stored in session
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        /** @var \Feedme\Models\Entities\User $user */
        $user = $this->session->get('auth');
        if (!$user) {
            $role = self::GUESTS;
        } elseif ($user["bAdmin"]) {
            $role = self::ADMINS;
        } else {
            $role = self::USERS;
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);

        if ($allowed != Acl::ALLOW) {
            HandlerSession::push($this->session, 'alerts', new Alert(
                "You don't have access to this module",
                Alert::LV_ERROR
            ));

            $dispatcher->forward(
                array(
                    'controller' => 'index',
                    'action' => 'index'
                )
            );

            return false;
        }
    }
}
