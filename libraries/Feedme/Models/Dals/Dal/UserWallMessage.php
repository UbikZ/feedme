<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\UserWall as EntityUserWall;
use Feedme\Models\Entities\UserWallMessage as EntityUserWallMessage;
use Feedme\Models\Messages\Filters\UserWallMessage\Select;
use Feedme\Models\Messages\Requests\UserWallMessage\Delete;
use Feedme\Models\Messages\Requests\UserWallMessage\Insert;
use Phalcon\Mvc\Model;

class UserWallMessage
{
    public function insert(Insert $request)
    {
        // Insert in UserWallMessage
        $userWallMessage = new EntityUserWallMessage();
        $userWallMessage->setMessage($request->message);
        $userWallMessage->setAdddate((new \DateTime())->format('Y-m-d H:i:s'));
        $userWallMessage->setIdMessageSrc($request->idMessageSrc);
        $userWallMessage->setIdUserSrc($request->idUserSrc);
        $resultWallMessage = $userWallMessage->save();

        // Insert in UserWall : TODO => put a trigger in database instead of this ugly thing
        $resultWall = true;
        if (is_null($request->idMessageSrc) && $resultWallMessage) {
            $userWall = new EntityUserWall();
            $userWall->setActive(true);
            $userWall->setIdUser($request->idUserDest);
            $userWall->setIdMessage($userWallMessage->getId());
            $resultWall = $userWall->save();
        }

        return $resultWall && $resultWallMessage;
    }

    public function find(Select $query)
    {
        return EntityUserWallMessage::find($this->_parseQuery($query));
    }

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

    private function _parseQuery(Select $query)
    {
        $whereClause = array();
        if (!is_null($idUserSrc = $query->idUserSrc)) {
            $whereClause[] = 'idUserSrc=\'' . intval($idUserSrc) . '\'';
        }
        if (!is_null($id = $query->id)) {
            $whereClause[] = 'id=\'' . intval($id) . '\'';
        }
        if (!is_null($idMessageSrc = $query->idMessageSrc)) {
            $whereClause[] = 'idMessageSrc=\'' . intval($idMessageSrc) . '\'';
        }

        return implode(' AND ', $whereClause);
    }
}
