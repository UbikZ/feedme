<?php

namespace Tests\Models\Dal;

use Feedme\Models\Messages\Filters\UserFeed\Select;
use Feedme\Models\Messages\Requests\Feed\Insert;

class FeedTest extends \PHPUnit_Framework_TestCase
{
    private $dalClass = 'Feedme\\Models\\Dals\\Dal\\Feed';
    private $entityClass = 'Feedme\\Models\\Entities\\Feed';

    public function testInsert()
    {
        // todo
    }

    public function testFind()
    {
        $parameter = new Select();
        $parameter->active = true;
        $parameter->connectedUserId = 123;
        $parameter->direction = 'DESC';
        $parameter->idFeed = 1;
        $parameter->like = true;
        $parameter->subscribe = false;
        $parameter->limit = 50;
        $parameter->order = 'subscribe';
        $parameter->identity = 456;
        $parameter->idUser = 789;

        /*$mock = $this->getMock($this->dalClass, array('parseFilter'));
        $mock->expects($this->any())->method('parseQuery')->with($parameter);
        $mock->expects($this->any())->method('parseFilterOptions')->with($parameter);
        $array = $mock->parseFilter($parameter);

        $stub = $this->getMockBuilder($this->entityClass)->disableOriginalConstructor()->getMock();
        $stub->expects($mock->parseFilter($parameter))->method('find')->will($this->returnValue(true));

        $this->assertEquals('resultSetInterface', $stub->find());*/
    }
}