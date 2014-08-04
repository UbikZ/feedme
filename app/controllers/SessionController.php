<?php

use Feedme\Models\Entities\User;
use Feedme\Models\Services\Service;

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
            $email = $request->getPost('email', 'email');
            $password = $request->getPost('password');

            /** @var User|bool $user */
            $user = Service::getService('User')->findFirst($email, $password);
            if (false !== $user) {
                $this->_registerSession($user);

                return $this->response->redirect('dashboard/index');
            }

            $this->flash->error('Authentication failed.');
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
