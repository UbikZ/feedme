<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\Filters\FeedType\Select;
use Feedme\Models\Entities\FeedType as EntityFeedType;

class FeedType extends BaseAbstract
{
    /**
     * @param  Select                                $query
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityFeedType::find($this->_parseFilter($query));
    }

    /**
     * @param  Select       $query
     * @return mixed|string
     */
    public function _parseQuery($query)
    {
        $whereClause = parent::_parseQuery($query);

        return $whereClause;
    }
}
