<?php

namespace Feedme\Parsers\Parser;

use Feedme\Parsers\Feed;

class Reddit extends ParseAbstract
{
    /** @return string */
    public function getRegPattern()
    {
        return sprintf('#<a href="%s">\[link\]</a>#', Feed::REG_URL);
    }

}
