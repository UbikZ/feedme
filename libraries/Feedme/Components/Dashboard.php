<?php

namespace Feedme\Components;

use Feedme\Com\Notification\Alert;

class Dashboard extends \Phalcon\Mvc\User\Component
{
    /**
     *
     */
    public function getUserMenu()
    {
        $items = array();
        $this->_addItem($items, 'Profile', array(), 'account', 'edit', array($this->session->get('auth')['id']));
        $this->_addItem($items, 'Wall', array(), 'wall', 'profile');
        $this->_addItem($items, '', array('divider'));
        $this->_addItem($items, 'Logout', array(), 'session', 'logout');

        $this->_renderLinksMenu($items);
    }

    /**
     *
     */
    public function getHeaderMenu()
    {
        $items = array();
        $this->_addItem($items, 'Logout', array(), 'session', 'logout', array(), 'fa fa-sign-out');

        $this->_renderLinksMenu($items);
    }

    /**
     *
     */
    public function getNavMenu()
    {
        $itemsCats = array();
        $auth = $this->session->get('auth');

        // Fill items
        $itemsAccount = array();
        $this->_addItem($itemsAccount, 'Manage', array(), 'account', 'edit', array($auth['id']));
        $this->_addItem($itemsAccount, 'Wall', array(), 'wall', 'profile');
        $this->_addItem($itemsAccount, 'Contacts', array(), 'contact', 'list');
        $this->_addCat($itemsCats, 'Account', $itemsAccount, 'fa fa-user');

        $itemsFeeds = array();
        $this->_addItem($itemsFeeds, 'New', array(), 'feed', 'new');
        $this->_addItem($itemsFeeds, 'List', array(), 'feed', 'list');
        $this->_addItem($itemsFeeds, 'Reader');
        $this->_addItem($itemsFeeds, 'Viewer');
        $this->_addItem($itemsFeeds, 'Statitics');
        $this->_addCat($itemsCats, 'Feeds', $itemsFeeds, 'fa fa-rss-square');

        if ($auth['bAdmin']) {
            $itemsAdmin = array();
            $this->_addItem($itemsAdmin, 'Users');
            $this->_addItem($itemsAdmin, 'Feeds');
            $this->_addItem($itemsAdmin, 'Statitics');
            $this->_addCat($itemsCats, 'Admin', $itemsAdmin, 'fa fa-gear');
        }

        $this->_renderCategoriesMenu($itemsCats);
    }

    /**
     * @param $cats
     */
    private function _renderCategoriesMenu($cats)
    {
        $render = '';
        if (is_array($cats)) {
            foreach ($cats as $cat) {
                $render .= '<li class="' . ($this->_isActive($cat) ? 'active' : '') . '">';
                $render .= '<a href="#">';
                if (isset($cat['img']))
                    $render .= '<i class="' . $cat['img'] . '"></i>';
                $render .= '<span class="nav-label">' . $cat['label'] . '</span>';
                $render .= '<span class="fa arrow"></span>';
                $render .= '</a>';
                $render .= '<ul class="nav nav-second-level">';
                $render .= $this->_renderLinksMenu($cat['items'], false);
                $render .= '</ul>';
                $render .= '</li>';
            }
        }

        echo $render;
    }

    /**
     * @param  array $category
     * @return bool
     */
    private function _isActive(array $category)
    {
        $controllers = array();
        foreach ($category['items'] as $item) {
            $controllers[] = $item['controller'];
        }

        return in_array($this->router->getControllerName(), $controllers);
    }

    /**
     * @param $items
     * @param  bool   $bDisplay
     * @return string
     */
    private function _renderLinksMenu($items, $bDisplay = true)
    {
        $render = '';
        if (is_array($items)) {
            foreach ($items as $item) {
                $content = '<a href="#">' . $item['label'] . '</a>';
                if (!is_null($ctrl = $item['controller']) && !is_null($act = $item['action'])) {
                    $params = (count($item['params']) > 0) ? '/' . implode('/', $item['params']) : '';
                    $link = $ctrl .'/'. $act . $params;
                    $caption = is_null($item['img'])
                        ? $item['label']
                        : '<i class="' . $item['img'] . '"></i>' . $item['label'];
                    $content = \Phalcon\Tag::linkTo($link, $caption);
                }
                $render .= '<li class="' . implode(' ', $item['classes']) . '">' . $content . '</li>';
            }
        }
        if ($bDisplay)
            echo $render;
        else
            return $render;
    }

    public function getAlerts()
    {
        $render = '';

        /** @var Alert[] $alerts */
        $alerts = $this->session->get('alerts');
        $count = count($alerts);
        $render .= '<li class="dropdown">';
        $render .= '<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">';
        $render .= '<i class="fa fa-bell"></i>';
        $render .= '<span class="label ' . ($count > 0 ? 'label-danger' : 'label-primary') . '">' . $count . '</span>';
        $render .= '</a>';
        if (is_array($alerts) && $count > 0) {
            $render .= '<ul class="dropdown-menu dropdown-messages">';
            foreach (array_slice(array_reverse($alerts), 0, 5) as $key => $alert) {
                $fa = '';
                switch ($alert->getLevel()) {
                    case Alert::LV_INFO:
                        $color = 'text-navy';
                        $label = 'Information';
                        $fa = 'fa fa-info';
                        break;
                    case Alert::LV_WARNING:
                        $color = 'text-warning';
                        $label = 'Warning';
                        $fa = 'fa fa-warning';
                        break;
                    case Alert::LV_ERROR:
                        $color = 'text-danger';
                        $label = 'Error';
                        $fa = 'fa fa-exclamation';
                        break;
                }
                $render .= '<li><div class="dropdown-messages-box">';
                $render .= '<div class="media-body">';
                $render .= '<i class="' . $fa . '"></i>&nbsp;.&nbsp;<small>' . $label . '</small><br/>';
                $render .= '<strong class="' . $color . '">'. $alert->getMessage() . '</strong><br/>';
                $render .= '<small class="text-muted pull-right">' . $alert->getDatetime()->format('H:i - d.m.Y') . '</small>';
                $render .= '</div></li>';
                if (($key + 1) != $count) {
                    $render .= '<li class="divider"></li>';
                }
            }
            $render .= '</ul>';
        }
        $render .= '</li>';

        echo $render;
    }

    /**
     * @param $conf
     * @param $label
     * @param  array              $items
     * @param  null               $img
     * @throws \Phalcon\Exception
     */
    private function _addCat(&$conf, $label, $items = array(), $img = null)
    {
        if (!is_array($conf)) {
            throw new \Phalcon\Exception(__CLASS__ . ' component issue: wrong type of parameters in ' . __FUNCTION__);
        }
        $conf[] = array(
            'label' => $label,
            'items' => $items,
            'img' => $img
        );
    }

    /**
     * @param $conf
     * @param $label
     * @param  array              $classes
     * @param  null               $controller
     * @param  null               $action
     * @param  array              $params
     * @param  null               $img
     * @throws \Phalcon\Exception
     */
    private function _addItem(
        &$conf,
        $label,
        $classes = array(),
        $controller = null,
        $action = null,
        $params = array(),
        $img = null
    )
    {
        if (!is_array($conf)) {
            throw new \Phalcon\Exception(__CLASS__ . ' component issue: wrong type of parameters in ' . __FUNCTION__);
        }
        $conf[] = array(
            'label' => $label,
            'classes' => $classes,
            'controller' => $controller,
            'action' => $action,
            'params' => $params,
            'img' => $img
        );
    }
}
