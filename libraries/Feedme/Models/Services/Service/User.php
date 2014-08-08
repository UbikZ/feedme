<?php

namespace Feedme\Models\Services\Service;

use Feedme\Models\Dals\Dal;

class User
{
    public function update($id, \Phalcon\Http\Request $request)
    {
        return Dal::getRepository('User')->update(
            $id,
            $request->getPost('firstname', 'scriptags'),
            $request->getPost('lastname', 'scriptags'),
            $request->getPost('username', 'scriptags'),
            $request->getPost('password')
        );
    }

    public function findFirst($email, $password)
    {
        return Dal::getRepository('User')->findFirst($email, $password);
    }

    public function findFirstById($id)
    {
        return Dal::getRepository('User')->findFirstById($id);
    }

    public function getLast()
    {
        return Dal::getRepository('User')->getLast();
    }
}
