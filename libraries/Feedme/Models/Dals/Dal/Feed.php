<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\Feed\Select;
use Feedme\Models\Messages\Requests\Feed\Insert;
use Feedme\Models\Entities\Feed as EntityFeed;
use Phalcon\Mvc\Model\Query\Builder;

class Feed extends BaseAbstract
{
    /**
     * @param  Insert     $request
     * @return DalMessage
     */
    public function insert(Insert $request)
    {
        $feed = new EntityFeed();

        $this->parseRequest($feed, $request);

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
        $result = EntityFeed::find($this->parseFilter($query));

        return $result;
    }

    /**
     * @return array
     */
    public function countLikes()
    {
        $builder = new Builder();
        $query = $builder->columns(array('feed.*', 'COUNT(uf.[like]) as count'))
            ->addFrom(self::FEED, 'feed')
            ->join(self::USER_FEED, 'uf.idFeed = feed.id', 'uf')
            ->where('uf.[like] = \'1\'')
            ->groupBy('feed.id')
            ->getQuery();

        return $query->execute()->toArray();
    }

    /**
     * @param  EntityFeed $feed
     * @param  Insert     $request
     * @return mixed|void
     */
    public function parseRequest(&$feed, $request)
    {
        parent::parseRequest($feed, $request);

        if (!is_null($request->idCreator)) {
            $feed->setIdCreator($request->idCreator);
        }
        if (!is_null($request->description)) {
            $feed->setDescription($request->description);
        }
        if (!is_null($request->public)) {
            $feed->setPublic($request->public);
        }
        if (!is_null($request->type)) {
            $feed->setType($request->type);
        }
        if (!is_null($request->label)) {
            $feed->setLabel($request->label);
        }
        if (!is_null($request->url)) {
            $feed->setUrl($request->url);
        }
        $feed->setValidate(1); // set validation to "waiting"
        $feed->setAdddate((new \DateTime())->format('Y-m-d H:i:s'));
    }

    /**
     * @param  Select       $query
     * @return mixed|string
     */
    public function parseQuery($query)
    {
        $whereClause = parent::parseQuery($query);

        if (!is_null($idCreator = $query->idCreator)) {
            $whereClause[] = 'idCreator=\'' . intval($idCreator) . '\'';
        }
        if (!is_null($public = $query->public)) {
            $orClause = array(
                'public=\'' . intval($public). '\'',
                'idCreator=\'' . intval($query->connectedUserId) . '\''
            );
            $whereClause[] = '(' . implode(' OR ', $orClause) . ')';
        }
        if (!is_null($needle = $query->needle)) {
            $whereClause[] = 'label like \'%' . $needle . '%\'';
        }
        if (!is_null($type = $query->type)) {
            $whereClause[] = 'type=\'' . intval($type) . '\'';
        }
        if (!is_null($query->validate)) {
            $validate = is_array($query->validate) ? $query->validate : array($query->validate);
            $whereClause[] = 'validate IN (\'' . implode("','", $validate) . '\')';
        }

        return $whereClause;
    }
}
