<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\Filters\UserPicture\Select;
use Feedme\Models\Entities\UserPicture as EntityUserPicture;

class UserPicture extends BaseAbstract
{
    /**
     * @param  Select              $query
     * @return EntityUserPicture[]
     */
    public function find(Select $query)
    {
        return EntityUserPicture::find($this->_parseFilter($query));
    }

    /**
     * @param  Select $query
     * @return string
     */
    public function _parseQuery($query)
    {
        $whereClause = parent::_parseQuery($query);

        if (!is_null($path = $query->path)) {
            $whereClause[] = 'path=\'' . $path . '\'';
        }

        return $whereClause;
    }
}
