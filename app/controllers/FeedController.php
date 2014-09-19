<?php

namespace controllers;

use Feedme\Com\Notification\Alert;
use Feedme\Models\Entities\Feed;
use Feedme\Models\Entities\FeedItem;
use Feedme\Models\Entities\UserFeed;
use Feedme\Models\Messages\Filters\FeedType\Select as SelectFeedType;
use Feedme\Models\Messages\Filters\Feed\Select as SelectFeed;
use Feedme\Models\Messages\Requests\Feed\Insert;
use Feedme\Models\Messages\Requests\UserFeed\Insert as InsertUserFeed;
use Feedme\Models\Messages\Filters\UserFeed\Select as SelectUserFeed;
use Feedme\Models\Messages\Requests\UserFeedItem\Update;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Feedme\Session\Handler as HandlerSession;
use Phalcon\Tag;

class FeedController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('feed');
        Tag::setTitle('Dashboard');
        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function newAction()
    {
        $request = $this->request;
        if (true === $request->isPost()) {
            $insert = new Insert();
            $insert->type = $request->getPost('type');
            $insert->public = $request->getPost('public');
            $insert->description = $request->getPost('description');
            $insert->url = $request->getPost('url');
            $insert->idCreator = $this->currentUser->getId();
            $insert->label = $request->getPost('label');
            $insert->active = true;

            /** @var ServiceMessage $insertFeedMsg */
            $insertFeedMsg = Service::getService('Feed')->insert($insert);

            if ($insertFeedMsg->getSuccess()) {
                HandlerSession::push($this->session, 'alerts', new Alert(
                    "Your account've been updated successfully",
                    Alert::LV_INFO
                ));
                $this->response->redirect('feed/list');
            } else {
                $this->errors = $insertFeedMsg->getErrorsArray();
            }
        }

        $select = new SelectFeedType();
        $select->active = true;
        /** @var ServiceMessage $findTypesMsg */
        $findTypesMsg = Service::getService('FeedType')->find($select);
        if ($findTypesMsg->getSuccess()) {
            $this->view->setVar('feedTypes', $findTypesMsg->getMessage());
            $this->view->setVar("name", array("main" => "Feed", "sub" => "Manage"));
        } else {
            $this->internalError();
        }
    }

    public function listAction()
    {
        $items = Service::getService('Feed')->countLikes();

        if ($items->getSuccess()) {
            $this->view->setVar('listFeeds', $items->getMessage());
            $this->view->setVar("name", array("main" => "Feed", "sub" => "List"));
        } else {
            $this->internalError();
        }
    }

    public function itemsAction()
    {
        $this->view->setVar("name", array("main" => "Feed", "sub" => "Items"));
    }

    public function itemsloadAction($page = 1)
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $request = $this->request;
        if (true === $request->isAjax()) {
            $feedsSerializabled = null;
            /** @var FeedItem[] $feedItems */
            $feedItems = $this->currentUser->getFeedItems($page);
            if (is_array($feedItems)) {
                $feedsSerializabled = array();
                foreach ($feedItems as $feed) {
                    $feedsSerializabled[] =
                        $feed->getSerializable(false);
                }
            }

            $response->setContent(json_encode(
                array(
                    'success' => !is_null($feedsSerializabled),
                    'items' => $feedsSerializabled,
                    'baseUri' => $this->url->getBaseUri()
                )
            ));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }

    public function viewAction()
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $request = $this->request;
        if ((true === $request->isPost()) && (true === $request->isAjax())) {
            $update =  new Update();
            $update->idFeedItem = $request->getPost('id');
            $update->idUser = $this->currentUser->getId();
            $update->seen = true;
            /** @var ServiceMessage $msgUpdate */
            $msgUpdate = service::getService('UserFeedItem')->update($update);
            $response->setContent(json_encode(
                array(
                    'success' => $msgUpdate->getSuccess(),
                    'errors' => $msgUpdate->getErrors(),
                )
            ));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }

    /**
     * ASYNCH
     * @return Response
     */
    public function loadAction()
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $request = $this->request;
        if ((true === $request->isPost()) && (true === $request->isAjax())) {
            $select = new SelectFeed();
            $select->public = true;
            $select->direction = $request->getPost('direction');
            $select->order = $request->getPost('order');
            $select->limit = $request->getPost('limit');
            $select->needle = $request->getPost('needle');
            $select->validate = $request->getPost('validate');
            $select->connectedUserId = $this->currentUser->getId();

            /** @var ServiceMessage $findFeeds */
            $findFeeds = Service::getService('Feed')->find($select);
            $feeds = $findFeeds->getMessage();

            $feedsSerializabled = array();
            /** @var Feed[] $feeds */
            foreach ($feeds as $feed) {
                $feedsSerializabled[] =
                    $feed->getSerializable(false, array('idUser' => $this->currentUser->getId()));
            }
            $response->setContent(json_encode(
                array(
                    'success' => $findFeeds->getSuccess(),
                    'feeds' => $feedsSerializabled,
                    'baseUri' => $this->url->getBaseUri()
                )
            ));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }

    /**
     * ASYNCH
     * @param  null     $idFeed
     * @return Response
     */
    public function refreshAction($idFeed = null)
    {
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $request = $this->request;
        if (!is_null($idFeed) && is_numeric($idFeed) && true === $request->isAjax()) {
            $select = new SelectFeed();
            $select->identity = $idFeed;
            /** @var ServiceMessage $findFeeds */
            $findFeeds = Service::getService('Feed')->find($select);
            /** @var Feed $feed */
            $feed = $findFeeds->getMessage()->getFirst();
            $response->setContent(json_encode(
                array(
                    'success' => $findFeeds->getSuccess(),
                    'countSubscribes' => intval($feed->countSubscribes()),
                    'countLikes' => intval($feed->countLikes())
                )
            ));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }

    /**
     * ASYNCH
     * @param  null     $scope
     * @return Response
     */
    public function postAction($scope = null)
    {
        $_allowedScope = array('subscribe', 'like');
        $response = new Response();
        $response->setContentType('application/json', 'UTF-8');
        $request = $this->request;
        if (true === $request->isPost() && true === $request->isAjax() && in_array($scope, $_allowedScope)) {
            $req = new InsertUserFeed();
            $req->idUser = $this->currentUser->getId();
            $req->idFeed = $request->getPost('idfeed');

            $value = filter_var($request->getPost('value'), FILTER_VALIDATE_BOOLEAN);
            $req->subscribe = ($scope == "subscribe") ? $value : null;
            $req->like = ($scope == "like") ? $value : null;

            /** @var ServiceMessage $msgInsert */
            $msgInsert = Service::getService('UserFeed')->insert($req);
            if (false === $msgInsert->getSuccess()) {
                $response->setContent(json_encode(array('success' => $msgInsert->getSuccess())));
            } else {
                $quer = new SelectUserFeed();
                $quer->idFeed = $request->getPost('idfeed');
                $quer->idUser = $this->currentUser->getId();
                /** @var ServiceMessage $msgFind */
                $msgFind = Service::getService('UserFeed')->find($quer);
                /** @var UserFeed $userFeed */
                $userFeed = $msgFind->getMessage();

                $message['success'] = $value ? "success" : "warning";
                if ($scope == 'subscribe') {
                    $val = $userFeed->getSubscribe();
                    $message['content'] = $value ? 'You have subscribed a new feed' : "You have unsubscribed a feed";
                } else {
                    $val = $userFeed->getLike();
                    $message['content'] = $value ? 'You have liked a new feed' : "You have unliked a feed";
                }
                $response->setContent(json_encode(
                    array(
                        'success' => $msgFind->getSuccess(),
                        'active' => filter_var($val, FILTER_VALIDATE_BOOLEAN),
                        'message' => $message
                    )
                ));
            }
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;
    }
}
