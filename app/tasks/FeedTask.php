<?php

use Feedme\Db\Handler as DbHandler;

class FeedTask extends AbstractTask
{
    public function exportAction($idFeed = null)
    {
        $sql = "SELECT * FROM feed WHERE validate='2'";

        $feeds = DbHandler::get()->fetchAll($sql);
        echo '<pre>' . print_r($feeds, true) . '</pre>';
    }
}
