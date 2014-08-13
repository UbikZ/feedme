<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\Filters\UserPicture\Select;
use Feedme\Models\Entities\UserPicture as EntityUserPicture;

class UserPicture
{
    /**
     * @param  Select              $query
     * @return EntityUserPicture[]
     */
    public function find(Select $query)
    {
        return EntityUserPicture::find($this->_parseFilter($query));
    }

    private function _parseFilter(Select $query)
    {
        $whereClause = array();
        if (!is_null($id = $query->id)) {
            $whereClause[] = 'id=\'' . intval($id) . '\'';
        }
        if (!is_null($path = $query->path)) {
            $whereClause[] = 'path=\'' . $path . '\'';
        }
        if (!is_null($active = $query->active)) {
            $whereClause[] = 'active=\'' . intval($active) . '\'';
        }

        return implode(' AND ', $whereClause);
    }
}
