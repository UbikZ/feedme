<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Logger\Factory;
use Feedme\Models\Entities\User as EntityUser;

class User
{
    public function update($id, $firstname, $lastname, $username, $password)
    {
        $user = new EntityUser();
        $user->setId($id);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setUsername($username);
        if ($password) {
            $user->setPassword(sha1($password));
        }

        $logger = Factory::getLogger('user');
        $logger->info(
            'UPDATE : ' . PHP_EOL .
            'id => ' . $id . PHP_EOL .
            'firstname => ' . $firstname . PHP_EOL .
            'lastname => ' . $lastname . PHP_EOL .
            'username => ' . $username . PHP_EOL .
            'password => ' . $password . PHP_EOL
        );
        $return = $user->save();
        $logger->info(print_r($return, true));

        return $user->save();
    }

    public function findFirst($email, $password)
    {
        $password = sha1($password);

        return EntityUser::findFirst("email='$email' AND password='$password' AND active='1'");
    }

    public function findFirstById($id)
    {
        return EntityUser::findFirstById($id);
    }

    public function getLast()
    {
        return EntityUser::query()->order('datetime DESC')->execute();
    }
}
