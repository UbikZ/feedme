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
    public function update(EntityUser $user, Update $request)
    {
        $this->_parseRequest($user, $request);

        return $user->update();
    }

    /**
     * @param  Select $query
     * @return mixed
     */
    public function find(Select $query)
    {
        return EntityUser::find($this->_parseQuery($query));
    }

    /**
     * @param EntityUser $user
     * @param Update     $request
     */
    private function _parseRequest(EntityUser &$user, Update $request)
    {
        $user->setId($request->id);
        $user->setFirstname($request->firstname);
        $user->setLastname($request->lastname);
        $user->setUsername($request->username);

        if (!empty($request->password)) {
            $user->setPassword(sha1($request->password));
        }
        if (!empty($request->picture)) {
            $user->setPicture($request->picture);
        }
        if (!is_null($request->admin)) {
            $user->setAdmin($request->admin);
        }
        if (!is_null($request->active)) {
            $user->setActive($request->active);
        }
        if (!is_null($request->address)) {
            $user->setAddress($request->address);
        }
        if (!is_null($request->society)) {
            $user->setSociety($request->society);
        }
        if (!is_null($request->about)) {
            $user->setAbout($request->about);
        }
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
}
