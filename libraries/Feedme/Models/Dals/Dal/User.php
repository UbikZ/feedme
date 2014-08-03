<?php

namespace Feedme\Models\Dals\Dal;

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
        $user->setPassword(sha1($password));

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
