<?php

namespace Tests\Models\Dal;

use Feedme\Models\Dals\Dal;

class DalTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRepositoryKO()
    {
        $this->assertInstanceOf(
            'Feedme\\Models\\Dals\\Exceptions\\InvalidRepositoryException',
            Dal::getRepository('TestFail')
        );
    }

    public function testGetRepositoryFeed()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\Feed', Dal::getRepository('Feed'));
    }

    public function testGetRepositoryFeedType()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\FeedType', Dal::getRepository('FeedType'));
    }

    public function testGetRepositoryFile()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\File', Dal::getRepository('File'));
    }

    public function testGetRepositoryUser()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\User', Dal::getRepository('User'));
    }

    public function testGetRepositoryUserFeed()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\UserFeed', Dal::getRepository('UserFeed'));
    }

    public function testGetRepositoryUserPicture()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\UserPicture', Dal::getRepository('UserPicture'));
    }

    public function testGetRepositoryUserWall()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\UserWall', Dal::getRepository('UserWall'));
    }

    public function testGetRepositoryUserWallMessage()
    {
        $this->assertInstanceOf('Feedme\\Models\\Dals\\Dal\\UserWallMessage', Dal::getRepository('UserWallMessage'));
    }
}
