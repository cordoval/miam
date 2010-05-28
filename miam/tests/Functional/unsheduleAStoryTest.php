<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class unsheduleAStoryTest extends \WebTestCase
{
    
    public function testSchedule()
    {
        $crawler = $this->client->request('GET', '/sprint/schedule');
    
        $this->client->click($crawler->filter('a.unshedule_story')->link());
        $this->client->followRedirect();
        
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:schedule');

        $this->addResponseTester();
        $this->client->assertResponseSelectCount('.col_left .story', 15);
        $this->client->assertResponseSelectCount('.col_right .story', 29);
        $this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('200'));
        $this->client->assertResponseSelectEquals('h3.story', array('_text'), array('Lister les ballades prévues'));
    }

}
