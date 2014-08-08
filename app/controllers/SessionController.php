<?php

use Feedme\Com\Notification\Alert;
use Feedme\Logger\Factory;
use Feedme\Models\Entities\User;
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
        $this->session->set('auth', array(
            "id" => $user->getId(),
            "firstname" => $user->getFirstname(),
            "lastname" => $user->getLastname(),
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
            $logger = Factory::getLogger('login');

            $email = $request->getPost('email', 'email');
            $password = $request->getPost('password');

            $logger->info("$email / $password");

            /** @var User|bool $user */
            $user = Service::getService('User')->findFirst($email, $password);
            if (false !== $user) {
                $this->_registerSession($user);
                $logger->notice($user->getId() . " / " . $user->getUsername());
                $this->session->remove('alerts');
                HandlerSession::push($this->session, 'alerts', new Alert(
                    "Connection granted!",
                    Alert::LV_INFO
                ));

                return $this->response->redirect('dashboard/index');
            }

            $msg = 'Authentication failed.';
            $logger->error($msg);
            $this->flash->error($msg);
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
