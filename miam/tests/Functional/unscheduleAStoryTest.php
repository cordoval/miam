<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class unscheduleAStoryTest extends \WebTestCase
{
    
    public function testSchedule()
    {
        $crawler = $this->client->request('GET', '/sprint/schedule');
        $this->client->assertResponseSelectEquals('.story_planCard .story_name', array('_text'), array('Smoke in the water'));
    
        $this->client->click($crawler->filter('span.unscheduleLink a')->link());
        $this->client->followRedirect();
        
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:schedule');

        $this->addResponseTester();
        $this->client->assertResponseSelectCount('.col_left .story', 15);
        $this->client->assertResponseSelectCount('.col_right .story', 29);
        $this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('205'));
        $this->client->assertResponseSelectEquals('.story_planCard .story_name', array('_text'), array('Smoke in the water'));
    }

}
