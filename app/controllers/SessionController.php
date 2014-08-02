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
        $this->session->set('user', $user);
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
            $user = new User();//Service::getService('User')->findFirst($username, $password);
            $user->setFirstname("Gabriel");
            $user->setLastname("Malet");
            $user->setId(123456);
            if (false !== $user) {
                $this->_registerSession($user);
                $this->flashSession->success('Welcome ' . $user->getFirstname() . ' ' . $user->getLastname());

                return $this->response->redirect('dashboard/index');
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
