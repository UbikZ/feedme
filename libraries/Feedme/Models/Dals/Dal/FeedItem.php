<?php

namespace Feedme\Models\Dals\Dal;

use Feedme\Models\Entities\FeedItem as EntityFeedItem;
use Feedme\Models\Messages\DalMessage;
use Feedme\Models\Messages\Filters\FeedItem\Select;
use Feedme\Models\Messages\Requests\FeedItem\Insert;

class FeedItem extends BaseAbstract
{
    /**
     * @param  Select                                $query
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(Select $query)
    {
        return EntityFeedItem::find($this->parseFilter($query));
    }

    /**
     * @param  Insert     $request
     * @return DalMessage
     */
    public function insert(Insert $request)
    {
        $feedItem = new EntityFeedItem();
        $this->parseRequest($feedItem, $request);

        $return = new DalMessage();
        $return->setSuccess($feedItem->save());
        $return->setErrorMessages($feedItem->getMessages());

        return $return;
    }

    /**
     * @param  Select      $query
     * @return array|mixed
     */
    public function parseQuery($query)
    {
        $whereClause = parent::parseQuery($query);

        if (!is_null($idHashed = $query->idHashed)) {
            $whereClause[] = 'idHashed=\'' . md5($idHashed) . '\'';
        }
        if (!is_null($authorName = $query->authorName)) {
            $whereClause[] = 'authorName LIKE \'%' . $authorName . '%\'';
        }
        if (!is_null($idFeed = $query->idFeed)) {
            $whereClause[] = 'idFeed=\'' . intval($idFeed) . '\'';
        }

        return $whereClause;
    }

    /**
     * @param  EntityFeedItem $feedItem
     * @param  Insert         $request
     * @return mixed|void
     */
    public function parseRequest(&$feedItem, $request)
    {
        parent::parseRequest($feedItem, $request);

        if (!is_null($request->idFeed)) {
            $feedItem->setIdFeed($request->idFeed);
        }
        if (!is_null($request->authorUri)) {
            $feedItem->setAuthorUri($request->authorUri);
        }
        if (!is_null($request->idHashed)) {
            $feedItem->setIdHashed(md5($request->idHashed));
        }
        if (!is_null($request->authorName)) {
            $feedItem->setAuthorName($request->authorName);
        }
        if (!is_null($request->adddate)) {
            $feedItem->setAdddate($request->adddate->format('Y-m-d H:i:s'));
        }
        if (!is_null($request->changedate)) {
            $feedItem->setChangedate($request->changedate->format('Y-m-d H:i:s'));
        }
        if (!is_null($request->categories)) {
            $feedItem->setCategories(implode(',', $request->categories));
        }
        if (!is_null($request->description)) {
            $feedItem->setSummary($request->description);
        }
        if (!is_null($request->link)) {
            $feedItem->setLink($request->link);
        }
        if (!is_null($request->title)) {
            $feedItem->setTitle($request->title);
        }
        if (!is_null($request->extract)) {
            $feedItem->setExtract(json_encode($request->extract));
        }
    }
}
