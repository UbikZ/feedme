<?php

namespace tasks;

use Feedme\Models\Entities\Feed;
use Feedme\Models\Messages\Filters\Feed\Select as SelectFeed;
use Feedme\Models\Messages\Requests\FeedItem\Insert as InsertFeedItem;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Feedme\Parsers\Feed as FeedParser;
use Zend\Feed\Reader\Feed\FeedInterface;
use Zend\Feed\Reader\Reader as FeedReader;

class FeedTask extends AbstractTask
{
    public function exportAction(array $params = array())
    {
        $selectFeed = new SelectFeed();
        $selectFeed->validate = 2;
        /** @var ServiceMessage $msgFeeds */
        $msgFeeds = Service::getService('Feed')->find($selectFeed);
        /** @var Feed $feed */
        foreach ($msgFeeds->getMessage() as $feed) {
            $idFeed = $feed->getId();
            $url = $feed->getUrl();
            if (!isset($idFeed) || !isset($url)) {
                throw new \Exception('Can\'t extract current feed.');
            }
            /** @var FeedInterface $entry */
            foreach (FeedReader::import($url) as $entry) {
                $insertFeedItem = new InsertFeedItem();
                $insertFeedItem->idFeed = $idFeed;
                $insertFeedItem->authorName = $entry->getAuthor();
                $insertFeedItem->idHashed = $entry->getId();
                $insertFeedItem->active = true;
                $insertFeedItem->link = $entry->getLink();
                $insertFeedItem->title = $entry->getTitle();
                $insertFeedItem->description = $entry->getDescription();
                $insertFeedItem->adddate = $entry->getDateCreated();
                $insertFeedItem->changedate = $entry->getDateModified();
                $insertFeedItem->extract = FeedParser::parseDescription(
                    $entry->getDescription(),
                    FeedParser::guessTypeForLink($entry->getLink())
                );

                /** @var ServiceMessage $resultMsg */
                $resultMsg = Service::getService('FeedItem')->insert($insertFeedItem);
                if (false == $resultMsg->getSuccess()) {
                    throw new \Exception($resultMsg->getMessage());
                }
            }
        }
    }
}
