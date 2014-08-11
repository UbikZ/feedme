<?php

use Feedme\Com\Notification\Alert;
use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\User\Select as SelectUser;
use Feedme\Models\Messages\Filters\UserPicture\Select as SelectUserPicture;
use Feedme\Models\Messages\Requests\User\Update;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Feedme\Session\Handler as HandlerSession;
use Feedme\Utils\Extract;
use Phalcon\Mvc\View;

class AccountController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('dashboard');
        Phalcon\Tag::setTitle('Dashboard');
        parent::initialize();
    }

    public function indexAction()
    {

        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function editAction($id = null)
    {
        if (!$id && ($id != $this->_getIdentity()['id']) && !$this->_isAdmin()) {
            $this->notFoundAction();
        }

        $query = new SelectUser();
        $query->id = $id;

        /** @var ServiceMessage $findUserMsg */
        $findUserMsg = Service::getService('User')->findFirst($query);

        if ($findUserMsg->getSuccess()) {
            /** @var User $user */
            $user = $findUserMsg->getMessage();
            if ($this->request->isPost()) {

                // Build update request object
                $request = new Update();
                $request->id = $id;
                $request->firstname = $this->request->getPost('firstname');
                $request->lastname = $this->request->getPost('lastname');
                $request->username = $this->request->getPost('username');
                $request->password = $this->request->getPost('password');
                $request->picture = $this->request->getPost('picture');

                /** @var ServiceMessage $updateUserMsg */
                $updateUserMsg = Service::getService('User')->update($request);

                if ($updateUserMsg->getSuccess()) {
                    HandlerSession::push($this->session, 'alerts', new Alert(
                        "Your account've been updated successfully",
                        Alert::LV_INFO
                    ));
                    $this->response->redirect('account/edit/2');
                } else {
                    HandlerSession::push(
                        $this->session,
                        'alerts',
                        new Alert($updateUserMsg->getErrors(), Alert::LV_ERROR)
                    );
                }
            }

            /** @var ServiceMessage $selectPictureMsg */
            $selectPictureMsg = Service::getService('UserPicture')->find(new SelectUserPicture());
            $images = $selectPictureMsg->getSuccess() ? $selectPictureMsg->getMessage() : array();

            $this->view->setVar("name", array("main" => "Account", "sub" => "Profile"));
            $queryPictures = new SelectUserPicture();
            $this->view->setVar("images", $images);
            $this->view->setVar("user", $user);

            $this->view->disableLevel(View::LEVEL_LAYOUT);
        } else {
            $this->notFoundAction();
        }
    }
}
