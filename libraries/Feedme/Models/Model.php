<?php

namespace Feedme\Models;

interface Model
{
    const USER = 'Feedme\\Models\\Entities\\User';
    const USER_PICTURE = 'Feedme\\Models\\Entities\\UserPicture';
    const USER_WALL = 'Feedme\\Models\\Entities\\UserWall';
    const USER_WALL_MESSAGE = 'Feedme\\Models\\Entities\\UserWallMessage';
    const USER_FEED = 'Feedme\\Models\\Entities\\UserFeed';
    const USER_FEED_ITEM = 'Feedme\\Models\\Entities\\UserFeedItem';
    const FEED = 'Feedme\\Models\\Entities\\Feed';
    const FEED_ITEM = 'Feedme\\Models\\Entities\\FeedItem';
    const FEED_TYPE = 'Feedme\\Models\\Entities\\FeedType';
}
