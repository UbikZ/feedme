<?php

namespace Tests;

use Phalcon\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Loader */
    private $_loader;

    public function setUp()
    {
        $this->_loader = new Loader();
    }

    public function tearDown()
    {
        $this->_loader->unregister();
    }
    
}
