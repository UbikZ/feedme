<?php

namespace controllers;

use Feedme\Com\Notification\Alert;
use Feedme\Models\Entities\User;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Feedme\Session\Handler as HandlerSession;

class SessionController extends AbstractController
{
    /**
     * Register authenticated user into session data
     *
     * @param User $user
     */
    private function _registerSession(User $user)
    {
        HandlerSession::push($this->session, 'auth', array(
            "id" => $user->getId(),
            "bAdmin" => $user->getAdmin()
        ));
    }

    /**
     * @return mixed
     */
    public function loginAction()
    {
        $request = $this->request;
        if ($request->isPost()) {
            // Instanciate filtering user parameters
            $query = new Select();
            $query->email = $request->getPost('email', 'email');
            $query->password = $request->getPost('password');

            /** @var ServiceMessage $message */
            $message = Service::getService('User')->find($query);
            if ($message->getSuccess()) {
                /** @var User $user */
                $user = $message->getMessage();
                $this->_registerSession($user);

                // Clean alerts session and add new ones
                $this->session->remove('alerts');
                HandlerSession::push($this->session, 'alerts', new Alert(
                    "Connection granted!",
                    Alert::LV_INFO
                ));

                return $this->response->redirect('dashboard/index');

            } else {
                $this->flash->error($message->getErrors());
            }
        }

        return $this->forward('/');
    }

    /**
     * @return mixed
     */
    public function logoutAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye and have an nice day!');

        return $this->forward('/');
    }
}
