<?php

namespace Feedme\Components;

class Dashboard extends \Phalcon\Mvc\User\Component
{
    public function getUserMenu()
    {
        $items = array();
        $this->_addItem($items, 'Profile', array(), 'account', 'edit', array($this->session->get('auth')['id']));
        $this->_addItem($items, '', array('divider'));
        $this->_addItem($items, 'Logout', array(), 'session', 'logout');
        
        $this->_renderMenu($items);
    }
    
    public function getHeaderMenu()
    {
        $items = array();
        $this->_addItem($items, 'Logout', array(), 'session', 'logout', array(), 'fa fa-sign-out');
        
        $this->_renderMenu($items);
    }

    public function getNavMenu()
    {
        $itemsCats = array();
        $auth = $this->session->get('auth');
        
        // Fill items
        $itemsAccount = array();
        $this->_addItem($itemsAccount, 'Profile', array(), 'account', 'edit', array($auth['id']));
        $this->_addItem($itemsAccount, 'Settings');
        $this->_addCat($itemsCats, 'Account', $itemsAccount, 'fa fa-user');

        $itemsFeeds = array();
        $this->_addItem($itemsFeeds, 'Manage');
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
        
        echo $this->_renderCategoriesMenu(itemsCats);
    }
    
    private function _renderCategoriesMenu($cats)
    {
        $render = '';
        if (is_array($cats)) {
            foreach ($cats as $cat) {
                $render .= '<li>';
                $render .= '<a href="#">';
                $render .= '<i class="' . implode(' ', $cat['img']) . '">' . $content . '</li>';
                $render .= '<span class="nav-label">' . $cat['label'] . '</span>';
                $render .= '<span class="fa arrow"></span>';
                $render .= '</a>';
                $render .= '<ul class="nav nav-second-level">';
                $render .= $this->_renderLinksMenu($cat['items']);
                $render .= '</ul>';
                $render .= '</li>';
            }
        }
        
        echo $render;
    }
    
    private function _renderLinksMenu($items)
    {
        $render = '';
        if (is_array($items)) {
            foreach ($items as $item) {
                $content = $item['label'];
                if (!is_null($ctrl = $item['controller']) && !is_null($act = $item['action'])) {
                    $link = $ctrl .'/'. $act;
                    $params = (count($item['params']) > 0) ? '/' . implode('/', $item['params']) : '';
                    $caption = is_null($item['img']) 
                        ? $item['label'] 
                        : '<i class"' . $item['img'] . '"></li>' . $item['label'];
                    $content = \Phalcon\Tag::linkTo($link, $caption);
                }
                $render .= '<li class="' . implode(' ', $item['classes']) . '">' . $content . '</li>';
            }
        }
        
        echo $render;
    }
    
    private function _addCat(&$conf, $label, $items = array(), $img = null)
    {
        if (!is_array($conf)) {
            throw new \Phalcon\Exception(__CLASS__ . ' component issue: wrong type of parameters in ' __FUNCTION__);
        }
        $conf[] = array(
            'label' => $label,
            'items' => $items,
            'img' => $img
        );
    }
    
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
            throw new \Phalcon\Exception(__CLASS__ . ' component issue: wrong type of parameters in ' __FUNCTION__);
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
