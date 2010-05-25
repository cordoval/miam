<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class scheduleASprintTest extends \WebTestCase
{
    
    public function testState()
    {
        $crawler = $this->client->request('GET', '/sprint/schedule');

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:schedule');

        $this->addResponseTester();
        $this->client->assertResponseSelectCount('.col_left .story', 11);
        $this->client->assertResponseSelectCount('.col_right .story', 26);
        $this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('261'));
        $this->client->assertResponseSelectEquals('h3.story', array('_text'), array('Smoke in the water'));
    }

    public function testSchedule()
    {
        $crawler = $this->client->request('GET', '/sprint/schedule');
    

        $form = $crawler->filter('#addStory')->form();
        $this->client->submit($form, array(
        ));
        $this->client->followRedirect();
        
        
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:schedule');

        $this->addResponseTester();
        $this->client->assertResponseSelectCount('.col_left .story', 10);
        $this->client->assertResponseSelectCount('.col_right .story', 27);
        $this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('271'));
        $this->client->assertResponseSelectEquals('h3.story', array('_text'), array('Danse on a volcano'));
    }

}
