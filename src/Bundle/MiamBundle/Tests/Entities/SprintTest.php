<?php

namespace Bundle\MiamBundle\Tests\Entities;

use Bundle\MiamBundle\Entities\Sprint;

require_once __DIR__.'/../../Entities/Sprint.php';
require_once __DIR__.'/../../Entities/Story.php';

class SprintTest extends \PHPUnit_Framework_TestCase
{

    public function testSchedule()
    {
        $sprint = new Sprint();
        $storyStub = $this->getMock('Story');
        $storyStub->expects($this->any())->method('setSprint')->will($this->returnValue(null));
        $sprint->addStory($storyStub);
    }

    protected function getStoryStub()
    {
        $stub = $this->getMock('Story');

        $stub->expects($this->any())
            ->method('getPoints')
            ->will($this->returnValue(10));

        return $stub;
    }

    public function testInitialStatus()
    {
        $sprint = new Sprint();
        $this->assertEquals(0, $sprint->getRemainingPoints());
        $this->assertTrue($sprint->getIsCurrent());
    }
}
