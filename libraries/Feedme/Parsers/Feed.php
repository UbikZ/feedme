<?php

namespace Feedme\Parsers;

use Feedme\Parsers\Exceptions\InvalidParserException;
use Feedme\Parsers\Exceptions\InvalidUrlFeedException;
use Feedme\Parsers\Parser\ParserInterface;

/**
 * UGLY THING for now
 * Improvements:
 *  - no zend
 *  - no static
 * Class Parser
 */
class Feed
{
    const REG_URL = 'http:\/\/[0-9a-zA-Z\-_\./]+';
    const REG_EXT = '/\.(jpg|png|jpeg|gif|png)$/i';

    /** @var  string  */
    protected $urlFeed;
    /** @var  array */
    protected $typesFeed;

    /**
     * @param $urlFeed
     * @param  null|array              $types
     * @throws InvalidUrlFeedException
     */
    public function __construct($urlFeed, $types = null)
    {
        if (is_null($urlFeed)) {
            throw new InvalidUrlFeedException('You have to use not null urlFeed');
        }
        $this->setUrlFeed($urlFeed);
        $this->setTypesFeed(is_null($types) ? array() : (is_array($types) ? $types : array($types)));
    }

    /**
     * @param $el
     * @return ParserInterface
     */
    public function parse($el)
    {
        return $this->getParser($el, $this->getUrlFeed());
    }

    /**
     * @param $el
     * @param $url
     * @return ParserInterface
     * @throws Exceptions\InvalidParserException
     */
    private function getParser($el, $url)
    {
        $types = $this->getTypesFeed();
        $className = 'common';
        if (!empty($types) && is_array($types)) {
            foreach ($types as $type) {
                if (preg_match('#[0-9a-zA-Z\-_\./]+' . $type . '.+#', $url) != 0) {
                    $className = $type;
                    break;
                }
            }
        }
        $className = ucfirst($className);
        $namespace = 'Feedme\\Parsers\\Parser\\' . $className;
        if (!class_exists($namespace)) {
            throw new InvalidParserException('Parser adapter `' . $namespace . '` does not exist');
        }

        return (new \ReflectionClass($namespace))->newInstance($el);
    }

    /**
     ** Getters & Setters
     **/

    /**
     * @param string $urlFeed
     */
    public function setUrlFeed($urlFeed)
    {
        $this->urlFeed = $urlFeed;
    }

    /**
     * @return string
     */
    public function getUrlFeed()
    {
        return $this->urlFeed;
    }

    /**
     * @param array $typesFeed
     */
    public function setTypesFeed($typesFeed)
    {
        $this->typesFeed = $typesFeed;
    }

    /**
     * @return array
     */
    public function getTypesFeed()
    {
        return $this->typesFeed;
    }
}
