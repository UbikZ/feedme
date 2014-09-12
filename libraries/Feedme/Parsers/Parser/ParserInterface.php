<?php

namespace Feedme\Parsers\Parser;

interface ParserInterface
{
    /**
     * @return mixed
     */
    public function getRegPattern();

    /**
     * @return bool
     */
    public function extract();

    /**
     * @return bool
     */
    public function stream();

    /**
     * @return bool
     */
    public function extractFromStream();
}
