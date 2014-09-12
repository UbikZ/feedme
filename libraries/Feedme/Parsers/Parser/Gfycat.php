<?php

namespace Feedme\Parsers\Parser;

class Gfycat extends ParserAbstract
{
    public function extractFromStream()
    {
        $return = false;
        $images = null;
        $parsedStream = htmlqp($this->getElementToParse(), '.page');
        $elements = $parsedStream->find('a');
        if (!is_array($elements)) {
            $images = array($elements->attr('href'));
        } else {
            foreach ($elements as $element) {
                $src = $element->attr('href');
                if ($src) {
                    $images[] = $src;
                }
            }
        }

        if (true == ($return = (is_array($images) && count($images) > 0))) {
            $this->imageOk = $images;
        }

        return $return;
    }
}
