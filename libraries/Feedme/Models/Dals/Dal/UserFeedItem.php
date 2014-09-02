<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\UserFeedItem as EntityUserFeedItem;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\UserFeedItem\Select;
use Feedme\Models\Messages\Requests\UserFeedItem\Update;

class UserFeedItem extends BaseAbstract
{
    /**
     * @param  EntityUserFeedItem $userFeedItem
     * @param  Update             $request
     * @return DalMessage
     */
    public function update(EntityUserFeedItem $userFeedItem, Update $request)
    {
        $this->parseRequest($userFeedItem, $request);

        $return = new DalMessage();
        $return->setSuccess($userFeedItem->update());
        $return->setErrorMessages($userFeedItem->getMessages());

        return $return;
    }

    /***
     * @param  Select                                $query
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityUserFeedItem::find($this->parseFilter($query));
    }

    /**
     * @param  EntityUserFeedItem $userFeedItem
     * @param  Update             $request
     * @return mixed|void
     */
    public function parseRequest(&$userFeedItem, $request)
    {
        parent::parseRequest($userFeedItem, $request);

        if (!is_null($request->seen)) {
            $userFeedItem->setSeen(intval($request->seen));
        }
        if (!is_null($request->like)) {
            $userFeedItem->setLike(intval($request->like));
        }
    }

    /**
     * @param  Select     $query
     * @return mixed|void
     */
    public function parseQuery($query)
    {
        $whereClause = parent::parseQuery($query);

        if (!is_null($seen = $query->seen)) {
            $whereClause[] = 'seen=\'' . intval($seen) . '\'';
        }
        if (!is_null($like = $query->like)) {
            $whereClause[] = 'like=\'' . intval(like) . '\'';
        }

        return $whereClause;
    }
}
