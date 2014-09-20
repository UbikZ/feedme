<?php

namespace Feedme\Parsers\Parser;

class Imgur extends ParserAbstract
{
    public function extractFromStream()
    {
        $images = null;

        $parsedStream = htmlqp($this->getElementToParse(), '#content .panel');
        $elements = $parsedStream->find('.wrapper img')->get();
        if (is_array($elements)) {
            if (count($elements) == 0) {
                $images = array($parsedStream->find('img')->attr('src'));
            } else {
                foreach ($elements as $element) {
                    $src = $element->getAttribute('data-src');
                    if ($src) {
                        $images[] = $src;
                    }
                }
            }
        }

        $return = (is_array($images) && count($images) > 0);
        if (true == $return) {
            $this->imageOk = $images;
        }

        return $return;
    }
}
