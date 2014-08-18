<?php

use Feedme\Models\Entities\User;
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

    public function informationAction($id = null)
    {
        $response = new Response();

        $this->view->disable();
        $request = $this->request;
        if ((true === $request->isAjax()) && !is_null($id)) {
            // Count posts account in wall controller
            $query = new Select();
            $query->idUserSrc = $id;
            /** @var ServiceMessage $countUserWallMsg */
            $countUserWallMsg = Service::getService('UserWallMessage')->count($query);

            // Get user wall
            $queryUser = new SelectUser();
            $queryUser->id = $id;
            /** @var ServiceMessage $userMsg */
            $userMsg = Service::getService('User')->find($queryUser);
            /** @var User $user */
            $user = $userMsg->getMessage();
            $response->setContent(json_encode(
                array(
                    'success' => $countUserWallMsg->getSuccess() && $userMsg->getSuccess(),
                    'allowDelete' => ($this->_currentUser->getId() == $user->getId())
                        || $this->_currentUser->getAdmin(),
                    'countPosts' => $countUserWallMsg->getMessage(),
                    'messages' => $user->getSerializable()['messages'],
                    'baseUri' => $this->url->getBaseUri()
                )
            ));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

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

    public function postAction($id = null)
    {
        $response = new Response();

        $this->view->disable();
        $request = $this->request;
        if ((true === $request->isPost()) && (true === $request->isAjax()) && !is_null($id)) {
            $insert = new Insert();
            $insert->idMessageSrc = $request->getPost('idMessageSrc');
            $insert->idUserSrc = $this->_currentUser->getId();
            $insert->idUserDest = $id;
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
