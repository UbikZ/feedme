<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\User as EntityUser;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\Requests\User\Update;

class User
{
    /**
     * @param  Update $request
     * @return mixed
     */
    public function update(Update $request)
    {
        $user = new EntityUser();
        $user->setId($request->id);
        $user->setFirstname($request->fistname);
        $user->setLastname($request->lastname);
        $user->setUsername($request->username);

        if (!is_null($request->password)) {
            $user->setPassword(sha1($request->password));
        }
        if (!is_null($request->admin)) {
            $user->setAdmin($request->admin);
        }
        if (!is_null($request->active)) {
            $user->setActive($request->active);
        }

        return $user->save();
    }

    /**
     * @param  Select $query
     * @return string
     */
    private function _parseQuery(Select $query)
    {
        $whereClause = array();
        if (!is_null($id = $query->id)) {
            $whereClause[] = 'id=\'' . intval($id) . '\'';
        }
        if (!is_null($email = $query->email)) {
            $whereClause[] = 'email=\'' . $email . '\'';
        }
        if (!is_null($password = $query->password)) {
            $whereClause[] = 'password=\'' . sha1($password) . '\'';
        }
        if (!is_null($active = $query->active)) {
            $whereClause[] = 'active=\'' . intval($active) . '\'';
        }
        if (!is_null($admin = $query->admin)) {
            $whereClause[] = 'admin=\'' . intval($admin) . '\'';
        }

        return implode(' AND ', $whereClause);
    }

    /**
     * @param  Select $query
     * @return mixed
     */
    public function findFirst(Select $query)
    {
        return EntityUser::findFirst($this->_parseQuery($query));
    }
}
