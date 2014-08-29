<?php

namespace tasks;

use Feedme\Cli\SimpleIO;
use Feedme\Db\Handler as DbHandler;

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
        }
    }
}
