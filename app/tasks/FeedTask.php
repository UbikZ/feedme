<?php

namespace tasks;

use Feedme\Models\Entities\Feed;
use Feedme\Models\Messages\Filters\Feed\Select as SelectFeed;
use Feedme\Models\Messages\Requests\FeedItem\Insert as InsertFeedItem;
use Feedme\Models\Messages\ServiceMessage;
use Feedme\Models\Services\Service;
use Feedme\Parsers\Feed as FeedParser;
use Feedme\Parsers\Parser\ParserAbstract;
use Zend\Feed\Reader\Feed\FeedInterface;
use Zend\Feed\Reader\Reader as FeedReader;

class FeedTask extends AbstractTask
{
    public function exportAction(array $params = array())
    {
        $typesFeed = array('reddit', 'imgur', 'gfycat');
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

                // Extraction feature

                /** @var ParserAbstract $feedParser */
                $feedParser = (new FeedParser($entry->getLink(), $typesFeed))->parse($entry->getDescription());
                $feedParser->extract(); // Extract what we need from description

                $imageViewable = $feedParser->imageOk;
                $imageNotViewable = $feedParser->imageKo;
                // If we have stream content, we create new instance of FeedParser to extract the content this time
                if ($feedParser->stream()) { // Stream content if image can't be loaded (html content instead)
                    /** @var ParserAbstract $streamParser */
                    $streamParser = (new FeedParser($feedParser->imageKo, $typesFeed))->parse($feedParser->stream);
                    $streamParser->extractFromStream();
                    $imageViewable = is_null($streamParser->imageOk) ? $imageViewable : $streamParser->imageOk;
                    $imageNotViewable = is_null($imageViewable) ? $imageNotViewable : null;
                }

                if (is_array($imageViewable)) {
                    foreach ($imageViewable as $key => $image) {
                        $clone = clone($insertFeedItem);
                        $clone->idHashed .= $key;
                        $clone->extract = array('imgViewable' => $image, 'imgNotViewable' => null);
                        $this->insertFeedItem($clone);
                        unset($clone);
                    }
                } else {
                    $insertFeedItem->extract = array(
                        'imgViewable' => $imageViewable,
                        'imgNotViewable' => $imageNotViewable
                    );
                    $this->insertFeedItem($insertFeedItem);
                }
            }
        }
    }

    /**
     * @param $insert
     * @throws \Exception
     */
    private function insertFeedItem($insert)
    {
        /** @var ServiceMessage $resultMsg */
        $resultMsg = Service::getService('FeedItem')->insert($insert);
        if (false == $resultMsg->getSuccess()) {
            throw new \Exception($resultMsg->getMessage());
        }
    }
}
