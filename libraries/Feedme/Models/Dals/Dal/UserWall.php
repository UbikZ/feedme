<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\Filters\UserWall\Select;
use Feedme\Models\Entities\UserWall as EntityUserWall;

class UserWall
{
    public function count(Select $query)
    {
        return EntityUserWall::count($this->_parseQuery($query));
    }

    private function _parseQuery(Select $query)
    {
        $whereClause = array();
        if (!is_null($idMessage = $query->idMessage)) {
            $whereClause[] = 'idMessage=\'' . intval($idMessage) . '\'';
        }
        if (!is_null($idUser = $query->idUser)) {
            $whereClause[] = 'idUser=\'' . intval($idUser) . '\'';
        }
        if (!is_null($active = $query->active)) {
            $whereClause[] = 'active=\'' . intval($active) . '\'';
        }

        return implode(' AND ', $whereClause);
    }
}
