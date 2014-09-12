<?php

namespace Feedme\Parsers\Parser;

use Feedme\Parsers\Feed;

class Reddit extends ParserAbstract
{
    /** @return string */
    public function getRegPattern()
    {
        return sprintf('#<a href="%s">\[link\]</a>#', Feed::REG_URL);
    }

    public function extractFromStream()
    {
        // Implement this to parse reddit html content
        return false;
    }

}
