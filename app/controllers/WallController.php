<?php

namespace controllers;

use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\UserWallMessage\Select;
use Feedme\Models\Messages\Filters\User\Select as SelectUser;
use Feedme\Models\Messages\Requests\UserWallMessage\Insert;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Phalcon\Tag;

class WallController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('wall');
        Tag::setTitle('Dashboard');
        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function profileAction($identity = null)
    {
        if (is_null($identity)) {
            $identity = $this->currentUser->getId();
        }

        $select = new SelectUser();
        $select->identity = $identity;
        /** @var ServiceMessage $findUserMsg */
        $findUserMsg = Service::getService('User')->find($select);

        if ($findUserMsg->getSuccess()) {
            $this->view->setVar('user', $findUserMsg->getMessage());
        } else {
            $this->internalError();
        }
        $this->view->setVar("name", array("main" => "Profile", "sub" => "Wall"));
    }

    public function informationAction($identity = null)
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $this->view->disable();
        $request = $this->request;
        if ((true === $request->isAjax()) && !is_null($identity)) {
            // Get user wall
            $queryUser = new SelectUser();
            $queryUser->identity = $identity;
            /** @var ServiceMessage $userMsg */
            $userMsg = Service::getService('User')->find($queryUser);
            /** @var User $user */
            $user = $userMsg->getMessage();
            $response->setContent(json_encode(
                array(
                    'success' => $userMsg->getSuccess(),
                    'allowDelete' => ($this->currentUser->getId() == $user->getId())
                        || $this->currentUser->getAdmin(),
                    'countPosts' => $user->countPostedMessages(),
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
            $this->internalError();
        }
    }

    public function postAction($idUserDest = null)
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $this->view->disable();
        $request = $this->request;
        if ((true === $request->isPost()) && (true === $request->isAjax()) && !is_null($idUserDest)) {
            $insert = new Insert();
            $insert->idMessageSrc = $request->getPost('idMessageSrc');
            $insert->idUserSrc = $this->currentUser->getId();
            $insert->idUserDest = $idUserDest;
            $insert->message = $request->getPost('message');

            /** @var ServiceMessage $insertMessage */
            $insertMessage = Service::getService('UserWallMessage')->insert($insert);

            $response->setContent(json_encode(array('success' => $insertMessage->getSuccess())));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }

    public function deleteAction($idMessage = null)
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $this->view->disable();
        $request = $this->request;
        if ((true === $request->isAjax()) && !is_null($idMessage)) {
            $delete = new Select();
            $delete->identity = $idMessage;
            $delete->idUserSrc = $this->currentUser->getId();

            /** @var ServiceMessage $deleteMessage */
            $deleteMessage = Service::getService('UserWallMessage')->delete($delete);

            $response->setContent(json_encode(array('success' => $deleteMessage->getSuccess())));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }
}
