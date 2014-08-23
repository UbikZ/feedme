<?php

use Feedme\Com\Notification\Alert;
use Feedme\Models\Entities\Feed;
use Feedme\Models\Entities\UserFeed;
use Feedme\Models\Messages\Filters\FeedType\Select as SelectFeedType;
use Feedme\Models\Messages\Filters\Feed\Select as SelectFeed;
use Feedme\Models\Messages\Requests\Feed\Insert;
use Feedme\Models\Messages\Requests\UserFeed\Insert as InsertUserFeed;
use Feedme\Models\Messages\Filters\UserFeed\Select as SelectUserFeed;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Feedme\Session\Handler as HandlerSession;

class FeedController extends AbstractController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->setTemplateAfter('feed');
        Phalcon\Tag::setTitle('Dashboard');
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
            $insert->idCreator = $this->_currentUser->getId();
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
                $this->_errors = $insertFeedMsg->getErrorsArray();
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
            $this->internalErrorAction();
        }
    }

    public function listAction()
    {
        $select = new SelectFeed();
        $select->public = true;
        $select->connectedUserId = $this->_currentUser->getId();

        /** @var ServiceMessage $findFeeds */
        $findFeeds = Service::getService('Feed')->find($select);

        if ($findFeeds->getSuccess()) {
            $this->view->setVar('listFeeds', $findFeeds->getMessage());
            $this->view->setVar("name", array("main" => "Feed", "sub" => "List"));
        } else {
            $this->internalErrorAction();
        }
    }

    public function loadAction()
    {
        $response = new Response();
        $request = $this->request;
        if ((true === $request->isPost()) && (true === $request->isAjax())) {
            $select = new SelectFeed();
            $select->public = true;
            $select->direction = $request->getPost('direction');
            $select->order = $request->getPost('order');
            $select->limit = $request->getPost('limit');
            $select->needle = $request->getPost('needle');
            $select->validate = $request->getPost('validate');
            $select->connectedUserId = $this->_currentUser->getId();

            /** @var ServiceMessage $findFeeds */
            $findFeeds = Service::getService('Feed')->find($select);
            $feeds = $findFeeds->getMessage();

            $listFeedsSerializabled = array();
            /** @var Feed[] $feeds */
            foreach ($feeds as $feed) {
                $listFeedsSerializabled[] =
                    $feed->getSerializable(false, array('idUser' => $this->_currentUser->getId()));
            }
            $response->setContent(json_encode(
                array(
                    'success' => $findFeeds->getSuccess(),
                    'feeds' => $listFeedsSerializabled,
                    'baseUri' => $this->url->getBaseUri()
                )
            ));
        } else {
            $response->setContent(json_encode(array('success' => false)));
        }

        return $response;

    }

    public function refreshAction($id = null)
    {
        $response = new Response();
        $request = $this->request;
        if (!is_null($id) && is_numeric($id) && true === $request->isAjax()) {
            $select = new SelectFeed();
            $select->id = $id;
            /** @var ServiceMessage $findFeeds */
            $findFeeds = Service::getService('Feed')->find($select);
            /** @var Feed $feed */
            $feed = $findFeeds->getMessage();
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

    public function postAction($scope = null)
    {
        $_allowedScope = array('subscribe', 'like');
        $response = new Response();
        $request = $this->request;
        if (true === $request->isPost() && true === $request->isAjax() && in_array($scope, $_allowedScope)) {
            $req = new InsertUserFeed();
            $req->idUser = $this->_currentUser->getId();
            $req->idFeed = $request->getPost('idfeed');

            $value = filter_var($request->getPost('value'), FILTER_VALIDATE_BOOLEAN);
            if ($scope == "subscribe") {
                $req->subscribe = $value;
            } else {
                $req->like = $value;
            }

            /** @var ServiceMessage $msgInsert */
            $msgInsert = Service::getService('UserFeed')->insert($req);
            if (false === $msgInsert->getSuccess()) {
                $response->setContent(json_encode(array('success' => $msgInsert->getSuccess())));
            } else {
                $quer = new SelectUserFeed();
                $quer->idFeed = $request->getPost('idfeed');
                $quer->idUser = $this->_currentUser->getId();
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
