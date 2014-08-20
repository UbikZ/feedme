<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\Filters\FeedType\Select;
use Feedme\Models\Entities\FeedType as EntityFeedType;

class FeedType
{
    /**
     * @param  Select                                $query
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityFeedType::find($this->_parseQuery($query));
    }

    /**
     * @param  Select $query
     * @return string
     */
    private function _parseQuery(Select $query)
    {
        $whereClause = array();
        if (!is_null($id = $query->id)) {
            $whereClause[] = 'id=\'' . intval($id) . '\'';
        }
        if (!is_null($active = $query->active)) {
            $whereClause[] = 'active=\'' . intval($active) . '\'';
        }

        return implode(' AND ', $whereClause);
    }
}
