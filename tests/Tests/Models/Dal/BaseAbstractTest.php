<?php

namespace Tests\Models\Dal;

class BaseAbstractTest extends \PHPUnit_Framework_TestCase
{
    private $class = 'Feedme\\Models\\Dals\\Dal\\BaseAbstract';
    private $baseFilterClass = 'Feedme\\Models\\Messages\\Filters\\Base';
    private $baseRequestClass = 'Feedme\\Models\\Messages\\Requests\\Base';
    private $entityClass = 'Feedme\\Models\\Entities\\EntityAbstract';

    public function testParseQuery()
    {
        $parameter = $this->getMockForAbstractClass($this->baseFilterClass);
        $parameter->identity = 1;
        $parameter->active = 0;
        $return = array('id=\'1\'', 'active=\'0\'');

        $mock = $this->getMockForAbstractClass($this->class);

        $this->assertEquals($return, $mock->parseQuery($parameter));
    }

    public function testParseFilterOptions()
    {
        $parameter = $this->getMockForAbstractClass($this->baseFilterClass);
        $parameter->limit = 10;
        $return = array('limit' => 10);

        $mock = $this->getMockForAbstractClass($this->class);

        $this->assertEquals($return, $mock->parseFilterOptions($parameter));
    }

    public function testParseRequest()
    {
    }

    public function testParseFilter()
    {
        $parameter = $this->getMockForAbstractClass($this->baseFilterClass);
        $parameter->identity = 5;
        $parameter->active = 0;
        $parameter->limit = 100;
        $return = array(
            'id=\'5\' AND active=\'0\'',
            'limit' => 100
        );

        $mock = $this->getMockForAbstractClass($this->class);
        $mock->expects($this->any())->method('parseQuery')->with($parameter);
        $mock->expects($this->any())->method('parseFilterOptions')->with($parameter);

        $this->assertEquals($return, $mock->parseFilter($parameter));
    }
}
