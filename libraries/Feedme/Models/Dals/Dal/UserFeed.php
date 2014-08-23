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
        return EntityUserFeed::find($this->_parseFilter($query));
    }

    /**
     * @param  Insert     $request
     * @return DalMessage
     */
    public function insert(Insert $request)
    {
        $userFeed = new EntityUserFeed();
        $this->_parseRequest($userFeed, $request);
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
        $this->_parseRequest($userFeed, $request);
        $return = new DalMessage();
        $return->setSuccess($userFeed->update());
        $return->setErrorMessages($userFeed->getMessages());

        return $return;
    }

    /**
     * @param  EntityUserFeed $uf
     * @param  Insert         $request
     * @return mixed|void
     */
    public function _parseRequest(&$uf, $request)
    {
        parent::_parseRequest($uf, $request);

        if (!is_null($request->idFeed)) {
            $uf->setIdFeed(intval($request->idFeed));
        }
        if (!is_null($request->idUser)) {
            $uf->setIdUser(intval($request->idUser));
        }
        if (!is_null($request->like)) {
            $uf->setLike(intval($request->like));
        }
        if (!is_null($request->subscribe)) {
            $uf->setSubscribe(intval($request->subscribe));
        }
    }

    /**
     * @param  Select       $query
     * @return mixed|string
     */
    public function _parseQuery($query)
    {
        $whereClause = parent::_parseQuery($query);

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
