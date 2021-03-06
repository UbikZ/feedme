<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\UserWall as EntityUserWall;
use Feedme\Models\Entities\UserWallMessage as EntityUserWallMessage;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\UserWallMessage\Select;
use Feedme\Models\Messages\Requests\UserWallMessage\Insert;
use Phalcon\Mvc\Model;

class UserWallMessage extends BaseAbstract
{
    /**
     * @param  Insert     $request
     * @return DalMessage
     */
    public function insert(Insert $request)
    {
        // Insert in UserWallMessage
        $userWallMessage = new EntityUserWallMessage();
        $userWallMessage->setMessage($request->message);
        $userWallMessage->setAdddate((new \DateTime())->format('Y-m-d H:i:s'));
        $userWallMessage->setIdMessageSrc($request->idMessageSrc);
        $userWallMessage->setIdUserSrc($request->idUserSrc);
        $resultWallMessage = $userWallMessage->save();

        $resultWall = true;
        if (is_null($request->idMessageSrc) && $resultWallMessage) {
            $userWall = new EntityUserWall();
            $userWall->setActive(true);
            $userWall->setIdUser($request->idUserDest);
            $userWall->setIdMessage($userWallMessage->getId());
            $resultWall = $userWall->save();
        }

        $return = new DalMessage();
        $return->setSuccess($resultWallMessage && $resultWall);
        $return->setErrorMessages($userWallMessage->getMessages());

        return $return;
    }

    /**
     * @param  Select                   $query
     * @return Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityUserWallMessage::find($this->parseFilter($query));
    }

    /**
     * @param  Select $query
     * @return int
     */
    public function count(Select $query)
    {
        return EntityUserWallMessage::count($this->parseFilter($query));
    }

    /**
     * @param  Select $query
     * @return bool
     */
    public function delete(Select $query)
    {
        $result = false;
        if (false !== ($rows = $this->find($query))) {
            foreach ($rows as $row) {
                if (($row instanceof Model) && false === $row->delete()) {
                    break;
                }
            }
            $result = true;
        }

        return $result;
    }

    /**
     * @param  Select       $query
     * @return mixed|string
     */
    public function parseQuery($query)
    {
        $whereClause = parent::parseQuery($query);

        if (!is_null($idUserSrc = $query->idUserSrc)) {
            $whereClause[] = 'idUserSrc=\'' . intval($idUserSrc) . '\'';
        }
        if (!is_null($idMessageSrc = $query->idMessageSrc)) {
            $whereClause[] = 'idMessageSrc=\'' . intval($idMessageSrc) . '\'';
        }

        return $whereClause;
    }
}
