<?php

namespace Bundle\MiamBundle\Tests\Entities;

use Bundle\MiamBundle\Entities\Story;

require_once 'PHPUnit/Framework.php';
require_once __DIR__.'/../../Entities/Story.php';

class StoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatedAtSetOnConstruction()
    {
        $story = new Story();
        $this->assertTrue($story->getCreatedAt() instanceof \DateTime);
    }

    public function testSetAndGetName()
    {
        $story = new Story();
        $story->setName('Once upon a time...');
        $this->assertEquals('Once upon a time...', $story->getName());
    }

    public function testGetId()
    {
        $story = new Story();
        $this->assertTrue(is_null($story->getId()));
    }
    
    public function testToString()
    {
        $story = new Story();
        $this->assertEquals('(story sans nom)', sprintf('%s', $story));
        
        $story->setName('Bla');
        $this->assertEquals('Bla', sprintf('%s', $story));
    }

    public function testInitialStatus()
    {
        $story = new Story();
        $this->assertEquals(Story::STATUS_CREATED, $story->getStatus());
        $this->assertEquals('created', $story->getStatusName());
    }

    public function testSetValidStatus()
    {
        $story = new Story();
        $story->setStatus(Story::STATUS_WIP);
        $this->assertEquals(Story::STATUS_WIP, $story->getStatus());
        $this->assertEquals('work in progress', $story->getStatusName());
    }

    /**
     * @expectedException \InvalidArgumentException
     **/
    public function testSetInvalidStatus()
    {
        $story = new Story();
        $story->setStatus('troublada');
    }

    public function testSetAndGetSprint()
    {
      $story = new Story();
      $story->setSprint(new Sprint());
    }
}
