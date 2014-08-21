<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\Feed\Select;
use Feedme\Models\Messages\Requests\Feed\Insert;
use Feedme\Models\Entities\Feed as EntityFeed;

class Feed
{
    /**
     * todo: create a parse request for this
     * @param  Insert     $request
     * @return DalMessage
     */
    public function insert(Insert $request)
    {
        $feed = new EntityFeed();
        $feed->setIdCreator($request->idCreator);
        $feed->setDescription($request->description);
        $feed->setPublic($request->public);
        $feed->setType($request->type);
        $feed->setLabel($request->label);
        $feed->setUrl($request->url);
        $feed->setValidate(1); // set validation to "waiting"
        $feed->setAdddate((new \DateTime())->format('Y-m-d H:i:s'));

        $return = new DalMessage();
        $return->setSuccess($feed->save());
        $return->setErrorMessages($feed->getMessages());

        return $return;
    }

    /**
     * @param  Select                                $query
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityFeed::find($this->_parseQuery($query));
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
        if (!is_null($idCreator = $query->idCreator)) {
            $whereClause[] = 'idCreator=\'' . intval($idCreator) . '\'';
        }
        if (!is_null($public = $query->public)) {
            $whereClause[] = 'public=\'' . intval($public). '\'';
        }
        if (!is_null($type = $query->type)) {
            $whereClause[] = 'type=\'' . intval($type) . '\'';
        }
        if (!is_null($validate = $query->validate)) {
            $whereClause[] = 'validate=\'' . intval($validate) . '\'';
        }

        return implode(' AND ', $whereClause);
    }
}
