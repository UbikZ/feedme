<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\User as EntityUser;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\User\Select;
use Feedme\Models\Messages\Requests\User\Update;

class User extends BaseAbstract
{
    /**
     * @param  EntityUser $user
     * @param  Update     $request
     * @return DalMessage
     */
    public function update(EntityUser $user, Update $request)
    {
        $this->parseRequest($user, $request);

        $return = new DalMessage();
        $return->setSuccess($user->update());
        $return->setErrorMessages($user->getMessages());

        return $return;
    }

    /**
     * @param  Select $query
     * @return mixed
     */
    public function find(Select $query)
    {
        return EntityUser::find($this->_parseFilter($query));
    }

    /**
     * @param  EntityUser $user
     * @param  Update     $request
     * @return mixed|void
     */
    public function parseRequest(&$user, $request)
    {
        parent::parseRequest($user, $request);

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
        if (!is_null($request->address)) {
            $user->setAddress($request->address);
        }
        if (!is_null($request->society)) {
            $user->setSociety($request->society);
        }
        if (!is_null($request->about)) {
            $user->setAbout($request->about);
        }
        if (!is_null($request->wallPicture)) {
            $user->setProfilePicture($request->wallPicture);
        }
    }

    /**
     * @param  Select       $query
     * @return mixed|string
     */
    public function parseQuery($query)
    {
        $whereClause = parent::parseQuery($query);

        if (!is_null($email = $query->email)) {
            $whereClause[] = 'email=\'' . $email . '\'';
        }
        if (!is_null($password = $query->password)) {
            $whereClause[] = 'password=\'' . sha1($password) . '\'';
        }
        if (!is_null($admin = $query->admin)) {
            $whereClause[] = 'admin=\'' . intval($admin) . '\'';
        }

        return $whereClause;
    }
}
