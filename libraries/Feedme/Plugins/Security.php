<?php

namespace Feedme\Plugins;

use \Phalcon\Events\Event,
    \Phalcon\Mvc\User\Plugin,
    \Phalcon\Mvc\Dispatcher,
    \Phalcon\Acl;

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
                        'session' => array('index', 'register', 'login')
                    )
                ),
                self::USERS => array(
                    'role' => new \Phalcon\Acl\Role(self::USERS),
                    'ressources' => array(
                        'index' => array('index'),
                        'dashboard' => array('index'),
                        'session' => array('logout')
                    )
                ),
                self::ADMINS => array(
                    'role' => new \Phalcon\Acl\Role(self::ADMINS),
                    'ressources' => array(
                        'index' => array('index'),
                        'admin' => array('index'),
                        'dashboard' => array('index'),
                        'session' => array('logout')
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
        $user = $this->session->get('user');
        if (!$user) {
            $role = self::GUESTS;
        }
       /* elseif ($user->getIsAdmin()) {
            $role = self::ADMINS;
        }*/ else {
            $role = self::USERS;
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);

        if ($allowed != Acl::ALLOW) {
            $this->flash->error("You don't have access to this module");
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
