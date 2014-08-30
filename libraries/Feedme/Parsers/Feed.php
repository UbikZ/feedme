<?php

namespace Feedme\Parsers;

use Feedme\Cli\SimpleIO;
use Feedme\Db\Handler as DbHandler;
use Zend\Feed\Reader\Feed\FeedInterface;
use Zend\Feed\Reader\Reader;

/**
 * UGLY THING for now
 * Improvements:
 *  - no zend
 *  - no static
 * Class Parser
 */
class Feed
{
    const TYPE_REDDIT = 'reddit';
    const TYPE_COMMON = 'common';
    const URL_PATTERN = 'http:\/\/[0-9a-zA-Z\-_\./]+';

    private static function _getPatterns($type = self::TYPE_COMMON)
    {
        $return = array(
            self::TYPE_REDDIT => '#<a href="%s">\[link\]</a>#',
            self::TYPE_COMMON => '#<img src="%s"/>#'
        );

        return isset($return[$type]) ? $return[$type] : '%s';
    }

    private static function _parseDescription($description, $type = self::TYPE_COMMON)
    {
        $pattern = sprintf(self::_getPatterns($type), self::URL_PATTERN);
        preg_match_all($pattern, $description, $matches);
        preg_match('#' . self::URL_PATTERN . '#', isset($matches[0][0]) ? $matches[0][0] : '', $descLink);

        return isset($descLink[0]) ? $descLink[0] : '';
    }

    private static function _guessTypeForLink($link)
    {
        $return = self::TYPE_COMMON;
        if (preg_match('#[0-9a-zA-Z\-_\./]+reddit.+#', $link) != 0) {
            $return = self::TYPE_REDDIT;
        }

        return $return;
    }

    public static function extractFeed($feed)
    {
        if (!isset($feed['id']) || !isset($feed['url'])) {
            throw new \Exception('Can\'t extract current feed');
        }
        self::getEntries($feed['url'], $feed['id']);
    }

    private static function getEntries($url, $idFeed)
    {
        if (!isset($url)) {
            throw new \Exception('Can\'t get entries');
        }

        /** @var FeedInterface $entry */
        foreach (Reader::import($url) as $entry) {
            $id = $entry->getId();
            if (!empty($id)) {
                $hashId = md5($id);
                $selectResult = DbHandler::get()->fetchAll("SELECT * FROM feed_item WHERE idHashed='" . $hashId . "'");
                if (is_array($selectResult) && count($selectResult) == 0) {
                    DbHandler::get()->insert(
                        'feed_item',
                        array(
                            $idFeed,
                            $hashId,
                            $entry->getTitle(),
                            implode(',', $entry->getCategories()->getValues()),
                            $entry->getAuthor(),
                            $entry->getLink(),
                            $entry->getDateCreated()->format('Y-m-d H:i:s'),
                            $entry->getDateModified()->format('Y-m-d H:i:s'),
                            $entry->getDescription(),
                            self::_parseDescription(
                                $entry->getDescription(),
                                self::_guessTypeForLink($entry->getLink())
                            ),
                            true
                        ),
                        array(
                            'idFeed',
                            'idHashed',
                            'title',
                            'categories',
                            'authorName',
                            'link',
                            'adddate',
                            'changedate',
                            'summary',
                            'extract',
                            'active'
                        )
                    );
                }
            }
        }
    }
}
