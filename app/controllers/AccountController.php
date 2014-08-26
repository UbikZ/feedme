<?php

namespace controllers;

use Feedme\Com\Notification\Alert;
use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\User\Select as SelectUser;
use Feedme\Models\Messages\Filters\UserPicture\Select as SelectUserPicture;
use Feedme\Models\Messages\Requests\User\Update;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Feedme\Session\Handler as HandlerSession;
use Phalcon\Mvc\View;
use Phalcon\Tag;

class AccountController extends AbstractController
{
    public function initialize()
    {
        $this->view->setTemplateAfter('dashboard');
        Tag::setTitle('Dashboard');
        parent::initialize();
    }

    public function indexAction()
    {

        $this->view->disableLevel(View::LEVEL_LAYOUT);
    }

    public function editAction($id = null)
    {
        if (!$id && ($id != $this->getIdentity()['id']) && !$this->isAdmin()) {
            $this->notFoundAction();
        }

        $query = new SelectUser();
        $query->id = $id;

        /** @var ServiceMessage $findUserMsg */
        $findUserMsg = Service::getService('User')->find($query);

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
                $request->society = $this->request->getPost('society');
                $request->address = $this->request->getPost('address');
                $request->about = $this->request->getPost('about');

                // todo: ugly => put this in File service asap
                if (true == ($this->request->hasFiles())) {
                    $files = $this->request->getUploadedFiles();
                    if (is_array($files) && isset($files[0])) {
                        $file = $files[0];
                        $filename = 'uploads/' . $user->getId() . '-' . $file->getName();
                        $file->moveTo(PUBLIC_PATH . '/' . $filename);
                        $request->wallPicture = $filename;
                    }
                }

                /** @var ServiceMessage $updateUserMsg */
                $updateUserMsg = Service::getService('User')->update($request);

                if ($updateUserMsg->getSuccess()) {
                    HandlerSession::push($this->session, 'alerts', new Alert(
                        "Your account've been updated successfully",
                        Alert::LV_INFO
                    ));
                    $this->response->redirect('account/edit/' .  $user->getId());
                } else {
                    HandlerSession::push($this->session, 'alerts', new Alert(
                        $updateUserMsg->getErrors(),
                        Alert::LV_ERROR
                    ));
                }
            }

            /** @var ServiceMessage $selectPictureMsg */
            $selectPictureMsg = Service::getService('UserPicture')->find(new SelectUserPicture());
            $images = $selectPictureMsg->getSuccess() ? $selectPictureMsg->getMessage() : array();

            $this->view->setVar("name", array("main" => "Account", "sub" => "Manager"));
            $queryPictures = new SelectUserPicture();
            $this->view->setVar("images", $images);
            $this->view->setVar("user", $user);

            $this->view->disableLevel(View::LEVEL_LAYOUT);
        } else {
            $this->notFoundAction();
        }
    }
}
