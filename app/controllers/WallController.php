<?php

use Feedme\Models\Messages\Filters\UserWall\Select as SelectUserWall;
use Feedme\Models\Messages\Filters\UserWallMessage\Select;
use Feedme\Models\Messages\Filters\User\Select as SelectUser;
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

    public function profileAction($id = null)
    {
        if (is_null($id)) {
            $id = $this->_currentUser->getId();
        }
        $select = new SelectUser();
        $select->id = $id;
        $findUserMsg = Service::getService('User')->find($select);

        if ($findUserMsg->getSuccess()) {
            $this->view->setVar('user', $findUserMsg->getMessage());
        } else {
            $this->internalErrorAction();
        }
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
                'messages' => $this->_currentUser->getSerializable()['messages'],
                'baseUri' => $this->url->getBaseUri()
            )
        ));

        return $response;
    }

    public function contactsAction()
    {
        /** @var ServiceMessage $findUserMsg */
        $findUserMsg = Service::getService('User')->find(new SelectUser());

        if ($findUserMsg->getSuccess()) {
            $this->view->setVar('users', $findUserMsg->getMessage());
            $this->view->setVar("name", array("main" => "Contacts", "sub" => "List"));
        } else {
            $this->internalErrorAction();
        }
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

    public function deleteAction($id = null)
    {
        $response = new Response();

        $this->view->disable();
        $request = $this->request;
        if ((true === $request->isAjax()) && !is_null($id)) {
            $delete = new Select();
            $delete->id = $id;
            $delete->idUserSrc = $this->_currentUser->getId();

            /** @var ServiceMessage $deleteMessage */
            $deleteMessage = Service::getService('UserWallMessage')->delete($delete);

            $response->setContent(json_encode(array('success' => $deleteMessage->getSuccess())));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }
}
