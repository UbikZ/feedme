<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\UserFeed\Select;
use Feedme\Models\Entities\UserFeed as EntityUserFeed;
use Feedme\Models\Messages\Requests\UserFeed\Insert;

class UserFeed extends BaseAbstract
{
    /**
     * @param  Select                                $query
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityUserFeed::find($this->parseFilter($query));
    }

    /**
     * @param  Insert     $request
     * @return DalMessage
     */
    public function insert(Insert $request)
    {
        $userFeed = new EntityUserFeed();
        $this->parseRequest($userFeed, $request);

        $return = new DalMessage();
        $return->setSuccess($userFeed->save());
        $return->setErrorMessages($userFeed->getMessages());

        return $return;
    }

    /**
     * @param  EntityUserFeed $userFeed
     * @param  Insert         $request
     * @return DalMessage
     */
    public function update(EntityUserFeed $userFeed, Insert $request)
    {
        $this->parseRequest($userFeed, $request);
        $return = new DalMessage();
        $return->setSuccess($userFeed->update());
        $return->setErrorMessages($userFeed->getMessages());

        return $return;
    }

    /**
     * @param  EntityUserFeed $userFeed
     * @param  Insert         $request
     * @return mixed|void
     */
    public function parseRequest(&$userFeed, $request)
    {
        parent::parseRequest($userFeed, $request);

        if (!is_null($request->idFeed)) {
            $userFeed->setIdFeed(intval($request->idFeed));
        }
        if (!is_null($request->idUser)) {
            $userFeed->setIdUser(intval($request->idUser));
        }
        if (!is_null($request->like)) {
            $userFeed->setLike(intval($request->like));
        }
        if (!is_null($request->subscribe)) {
            $userFeed->setSubscribe(intval($request->subscribe));
        }
    }

    /**
     * @param  Select       $query
     * @return mixed|string
     */
    public function parseQuery($query)
    {
        $whereClause = parent::parseQuery($query);

        if (!is_null($idUser = $query->idUser)) {
            $whereClause[] = 'idUser=\'' . intval($idUser) . '\'';
        }
        if (!is_null($idFeed = $query->idFeed)) {
            $whereClause[] = 'idFeed=\'' . intval($idFeed) . '\'';
        }
        if (!is_null($like = $query->like)) {
            $whereClause[] = '[like]=\'' . intval($like) . '\'';
        }
        if (!is_null($subscribe = $query->subscribe)) {
            $whereClause[] = 'subscribe=\'' . intval($subscribe) . '\'';
        }

        return $whereClause;
    }
}
