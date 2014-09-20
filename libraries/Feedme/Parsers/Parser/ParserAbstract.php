<?php

namespace Feedme\Parsers\Parser;

use Feedme\Parsers\Feed;
use Phalcon\Http\Client\Request;

abstract class ParserAbstract implements ParserInterface
{
    /** @var  string */
    protected $elementToParse;

    /** @var  string|array */
    public $imageOk;
    /** @var  string */
    public $imageKo;
    /** @var  string */
    public $stream;

    public function __construct($element)
    {
        $this->setElementToParse($element);
    }

    /**
     * @return string
     */
    public function getRegPattern()
    {
        return sprintf('#<img src="%s"/>#', Feed::REG_URL);
    }

    /**
     * @return bool
     */
    public function extract()
    {
        $return = false;

        preg_match_all($this->getRegPattern(), $this->getElementToParse(), $matches);
        preg_match('#' . Feed::REG_URL . '#', isset($matches[0][0]) ? $matches[0][0] : '', $link);

        $resultMatch = isset($link[0]) ? $link[0] : null;
        if (!is_null($resultMatch)) {
            if (preg_match(Feed::REG_EXT, $resultMatch) == 0) {
                $this->imageKo = $resultMatch;
            } else {
                $this->imageOk = $resultMatch;
            }
            $return = true;
        }

        return $return;
    }

    /**
     * @return bool
     */
    public function extractFromStream()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function stream()
    {
        $return = false;

        if (!is_null($link = $this->imageKo)) {
            // Get on the link to extract picture(s)
            $provider  = Request::getProvider();
            $response = $provider->get($link);
            $this->stream = $response->body;
            $return = true;
        }

        return $return;
    }

    /**
     ** Getters & Setters
     **/

    /**
     * @param string $elementToParse
     */
    public function setElementToParse($elementToParse)
    {
        $this->elementToParse = $elementToParse;
    }

    /**
     * @return string
     */
    public function getElementToParse()
    {
        return $this->elementToParse;
    }
}
