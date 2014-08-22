<?php

use Feedme\Com\Notification\Alert;
use Feedme\Models\Messages\Filters\FeedType\Select as SelectFeedType;
use Feedme\Models\Messages\Filters\Feed\Select as SelectFeed;
use Feedme\Models\Messages\Requests\Feed\Insert;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
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
        /** @var ServiceMessage $findFeeds */
        $findFeeds = Service::getService('Feed')->find($select);

        if ($findFeeds->getSuccess()) {
            $this->view->setVar('listFeeds', $findFeeds->getMessage());
            $this->view->setVar("name", array("main" => "Feed", "sub" => "List"));
        } else {
            $this->internalErrorAction();
        }
    }

    public function asynchToggleSubscribe()
    {

    }

    public function asynchToggleLike()
    {

    }
}
