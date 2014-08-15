<?php

use Feedme\Models\Messages\Filters\UserWall\Select as SelectUserWall;
use Feedme\Models\Messages\Requests\UserWallMessage\Insert;
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

    public function profileAction()
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

    public function postAction()
    {
        $response = new Response();

        $this->view->disable();
        $request = $this->request;
        if ((true === $request->isPost()) && (true === $request->isAjax())) {
            $insert = new Insert();
            $insert->idMessageSrc = $request->getPost('idMessageSrc');
            $insert->idUserSrc = $this->_currentUser->getId();
            $insert->idUserDest = $request->getPost('idUserDest', null, $this->_currentUser->getId());
            $insert->message = $request->getPost('message');

            /** @var ServiceMessage $insertMessage */
            $insertMessage = Service::getService('UserWallMessage')->insert($insert);

            $response->setContent(json_encode(array('success' => $insertMessage->getSuccess())));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }
}
