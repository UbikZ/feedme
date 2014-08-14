<?php

use Feedme\Models\Messages\Filters\UserWall\Select as SelectUserWall;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;

class WallController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('wall');
        Phalcon\Tag::setTitle('Dashboard');
        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function indexAction()
    {
        $this->view->setVar("name", array("main" => "Profile", "sub" => "Wall"));
    }

    public function informationAction()
    {
        $this->view->disable();

        // Count posts account in wall controller
        $query = new SelectUserWall();
        $query->idUser = $this->_getIdentity()['id'];
        /** @var ServiceMessage $countUserWallMsg */
        $countUserWallMsg = Service::getService('UserWall')->count($query);

        $response = new Response();
        $response->setContent(json_encode(
            array(
                'success' => $countUserWallMsg->getSuccess(),
                'countPosts' => $countUserWallMsg->getMessage(),
                'messages' => $this->_currentUser->getSerializable()['messages']
            )
        ));

        return $response;
    }
}
