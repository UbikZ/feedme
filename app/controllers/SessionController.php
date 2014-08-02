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
            'id' => $user->getId(),
            'firsname' => $user->getFirstname(),
            'lastname' => $user->getLastname()
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
            $user = false;//Service::getService('User')->findFirst($username, $password);
            if (false !== $user) {
                $this->_registerSession($user);
                $this->flashSession->success('Welcome ' . $user->getFirstname() . ' ' . $user->getLastname());

                return $this->forward('invoices/index');
            }

            $this->flashSession->error('Wrong email/password');
        }

        return $this->forward('/');
    }

    /**
     * @return mixed
     */
    public function logoutAction()
    {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');

        return $this->forward('/');
    }
}
