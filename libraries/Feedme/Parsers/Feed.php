<?php

namespace Feedme\Parsers;

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
    const EXT_PATTERN = '/\.(jpg|png|jpeg|gif|png)$/i';

    private static function getPatterns($type = self::TYPE_COMMON)
    {
        $return = array(
            self::TYPE_REDDIT => '#<a href="%s">\[link\]</a>#',
            self::TYPE_COMMON => '#<img src="%s"/>#'
        );

        return isset($return[$type]) ? $return[$type] : '%s';
    }

    public static function parseDescription($description, $type = self::TYPE_COMMON)
    {
        $pattern = sprintf(self::getPatterns($type), self::URL_PATTERN);
        preg_match_all($pattern, $description, $matches);
        preg_match('#' . self::URL_PATTERN . '#', isset($matches[0][0]) ? $matches[0][0] : '', $descLink);

        $resultMatch = isset($descLink[0]) ? $descLink[0] : null;
        $return = null;
        if (!is_null($resultMatch)) {
            if (preg_match(self::EXT_PATTERN, $resultMatch) == 0) {
                $return['imgNotViewable'] = $resultMatch;
            } else {
                $return['imgViewable'] = $resultMatch;
            }
        }

        return $return;
    }

    public static function guessTypeForLink($link)
    {
        $return = self::TYPE_COMMON;
        if (preg_match('#[0-9a-zA-Z\-_\./]+reddit.+#', $link) != 0) {
            $return = self::TYPE_REDDIT;
        }

        return $return;
    }
}
