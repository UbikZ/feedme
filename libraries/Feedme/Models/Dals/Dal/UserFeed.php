<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\UserFeed\Select;
use Feedme\Models\Entities\UserFeed as EntityUserFeed;
use Feedme\Models\Messages\Requests\UserFeed\Insert;

class UserFeed
{
    /**
     * @param  Select                                $query
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityUserFeed::find($this->_parseQuery($query));
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
     * @param EntityUserFeed $uf
     * @param Insert         $request
     */
    private function _parseRequest(EntityUserFeed &$uf, Insert $request)
    {
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
     * @param  Select $query
     * @return string
     */
    private function _parseQuery(Select $query)
    {
        $whereClause = array();
        if (!is_null($idUser = $query->idUser)) {
            $whereClause[] = 'idUser=\'' . intval($idUser) . '\'';
        }
        if (!is_null($idFeed = $query->idFeed)) {
            $whereClause[] = 'idFeed=\'' . $idFeed . '\'';
        }
        if (!is_null($like = $query->like)) {
            $whereClause[] = '[like]=\'' . intval($like) . '\'';
        }
        if (!is_null($subscribe = $query->subscribe)) {
            $whereClause[] = 'subscribe=\'' . intval($subscribe) . '\'';
        }

        return implode(' AND ', $whereClause);
    }
}
