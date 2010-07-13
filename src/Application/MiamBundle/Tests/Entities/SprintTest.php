<?php

namespace Application\MiamBundle\Tests\Entities;

use Application\MiamBundle\Entities\Sprint;

require_once __DIR__.'/../../Entities/Sprint.php';
require_once __DIR__.'/../../Entities/Story.php';

class SprintTest extends \PHPUnit_Framework_TestCase
{

    public function testSchedule()
    {
        $sprint = new Sprint();

        for($it=0; $it<3; $it++)
        {
            $storyStub = $this->getMock(
                'Application\MiamBundle\Entities\Story',
                array('setSprint', 'getPoints', 'isFinished')
            );
            $storyStub->expects($this->any())
                ->method('setSprint')
                ->will($this->returnValue(null));
            $storyStub->expects($this->any())
                ->method('getPoints')
                ->will($this->returnValue(10));
            $storyStub->expects($this->any())
                ->method('isFinished')
                ->will($this->returnValue(false));

            $sprint->addStory($storyStub);
        }
        $this->assertEquals(30, $sprint->getRemainingPoints());

        return $sprint;
    }

    /**
     * @depends testSchedule
     */
    public function testGetStoriesReturnsAllAssignedStories($sprint)
    {
        $stories = $sprint->getStories();
        $this->assertEquals(3, count($stories));
    }

    /**
     * @depends testSchedule
     */
    public function testRemoveStoryDecresasesTheStoryCount($sprint)
    {
        $stories = $sprint->getStories();
        $story = array_shift($stories);
        $sprint->removeStory($story);
        $this->assertEquals(2, count($sprint->getStories()));
    }

    public function testGetRemainingPoints()
    {
        $sprint = $this->testSchedule();
        $this->assertEquals(30, $sprint->getRemainingPoints());
    } 

    public function testInitialStatus()
    {
        $sprint = new Sprint();
        $this->assertEquals(0, $sprint->getRemainingPoints());
        $this->assertTrue($sprint->getIsCurrent());
    }
}
