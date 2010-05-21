<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class showCurrentSprintTest extends \WebTestCase
{
    
    public function testShowSprint()
    {
        $crawler = $this->client->request('GET', '/sprint');

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_current');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:current');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('h1.sprint', array('_text'), array('Current sprint'));
    }

}
