<?php

namespace tasks;

use Feedme\Cli\SimpleIO;
use Feedme\Db\Handler as DbHandler;
use Feedme\Parsers\Feed;

class FeedTask extends AbstractTask
{
    public function exportAction(array $params = array())
    {
        // Just validated feeds
        $sql = "SELECT * FROM feed WHERE validate='2'";
        $feeds = DbHandler::get()->fetchAll($sql);
        if (is_array($feeds)) {
            if (count($feeds) == 0) {
                SimpleIO::error('There is not feed');
            }
            foreach ($feeds as $feed) {
                Feed::extractFeed($feed);
            }
        }
    }
}
