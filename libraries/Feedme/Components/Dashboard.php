<?php

namespace Feedme\Components;

use Feedme\Com\Notification\Alert;
use Phalcon\Exception;
use Phalcon\Mvc\User\Component;
use Phalcon\Tag;

class Dashboard extends Component
{
    /**
     *
     */
    public function getUserMenu()
    {
        $items = array();
        $this->addItem($items, 'Profile', array(), 'account', 'edit', array($this->session->get('auth')['id']));
        $this->addItem($items, 'Wall', array(), 'wall', 'profile');
        $this->addItem($items, '', array('divider'));
        $this->addItem($items, 'Logout', array(), 'session', 'logout');

        $this->renderLinksMenu($items);
    }

    /**
     *
     */
    public function getHeaderMenu()
    {
        $items = array();
        $this->addItem($items, 'Logout', array(), 'session', 'logout', array(), 'fa fa-sign-out');

        $this->renderLinksMenu($items);
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
        $this->addItem($itemsAccount, 'Manage', array(), 'account', 'edit', array($auth['id']));
        $this->addItem($itemsAccount, 'Wall', array(), 'wall', 'profile');
        $this->addItem($itemsAccount, 'Contacts', array(), 'contact', 'list');
        $this->addCat($itemsCats, 'Account', $itemsAccount, 'fa fa-user');

        $itemsFeeds = array();
        $this->addItem($itemsFeeds, 'New', array(), 'feed', 'new');
        $this->addItem($itemsFeeds, 'List', array(), 'feed', 'list');
        $this->addItem($itemsFeeds, 'Items', array(), 'feed', 'items');
        $this->addCat($itemsCats, 'Feeds', $itemsFeeds, 'fa fa-rss-square');

        if ($auth['bAdmin']) {
            $itemsAdmin = array();
            $this->addItem($itemsAdmin, 'Users');
            $this->addItem($itemsAdmin, 'Feeds');
            $this->addItem($itemsAdmin, 'Statitics');
            $this->addCat($itemsCats, 'Admin', $itemsAdmin, 'fa fa-gear');
        }

        $this->renderCategoriesMenu($itemsCats);
    }

    /**
     * @param $cats
     */
    private function renderCategoriesMenu($cats)
    {
        $render = '';
        if (is_array($cats)) {
            foreach ($cats as $cat) {
                $render .= '<li class="' . ($this->isActive($cat) ? 'active' : '') . '">';
                $render .= '<a href="#">';
                if (isset($cat['img'])) {
                    $render .= '<i class="' . $cat['img'] . '"></i>';
                }
                $render .= '<span class="nav-label">' . $cat['label'] . '</span>';
                $render .= '<span class="fa arrow"></span>';
                $render .= '</a>';
                $render .= '<ul class="nav nav-second-level">';
                $render .= $this->renderLinksMenu($cat['items'], false);
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
    private function isActive(array $category)
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
    private function renderLinksMenu($items, $bDisplay = true)
    {
        $render = '';
        if (is_array($items)) {
            foreach ($items as $item) {
                $content = '<a href="#">' . $item['label'] . '</a>';
                if (!is_null($ctrl = $item['controller']) && !is_null($act = $item['action'])) {
                    $params = (count($item['params']) > 0) ? '/' . implode('/', $item['params']) : '';
                    $link = $ctrl . '/' . $act . $params;
                    $caption = is_null($item['img'])
                        ? $item['label']
                        : '<i class="' . $item['img'] . '"></i>' . $item['label'];
                    $content = Tag::linkTo($link, $caption);
                }
                $render .= '<li class="' . implode(' ', $item['classes']) . '">' . $content . '</li>';
            }
        }
        if ($bDisplay) {
            echo $render;
        } else {
            return $render;
        }
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
                $render .= '<strong class="' . $color . '">' . $alert->getMessage() . '</strong><br/>';
                $render .= '<small class="text-muted pull-right">';
                $render .= $alert->getDatetime()->format('H:i - d.m.Y');
                $render .= '</small>';
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
     * @param  array     $items
     * @param  null      $img
     * @throws Exception
     */
    private function addCat(&$conf, $label, $items = array(), $img = null)
    {
        if (!is_array($conf)) {
            throw new Exception(__CLASS__ . ' component issue: wrong type of parameters in ' . __FUNCTION__);
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
     * @param  array     $classes
     * @param  null      $controller
     * @param  null      $action
     * @param  array     $params
     * @param  null      $img
     * @throws Exception
     */
    private function addItem(
        &$conf,
        $label,
        $classes = array(),
        $controller = null,
        $action = null,
        $params = array(),
        $img = null
    ) {
        if (!is_array($conf)) {
            throw new Exception(__CLASS__ . ' component issue: wrong type of parameters in ' . __FUNCTION__);
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
