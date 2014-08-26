<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\Filters\UserWall\Select;
use Feedme\Models\Entities\UserWall as EntityUserWall;

class UserWall extends BaseAbstract
{
    /**
     * @param  Select $query
     * @return int
     */
    public function count(Select $query)
    {
        return EntityUserWall::count($this->_parseFilter($query));
    }

    /**
     * @param  Select       $query
     * @return mixed|string
     */
    public function parseQuery($query)
    {
        $whereClause = parent::parseQuery($query);

        if (!is_null($idMessage = $query->idMessage)) {
            $whereClause[] = 'idMessage=\'' . intval($idMessage) . '\'';
        }
        if (!is_null($idUser = $query->idUser)) {
            $whereClause[] = 'idUser=\'' . intval($idUser) . '\'';
        }

        return $whereClause;
    }
}
