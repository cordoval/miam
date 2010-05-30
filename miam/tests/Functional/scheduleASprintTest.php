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
        $this->client->assertResponseSelectCount('.col_left .story', 14);
        $this->client->assertResponseSelectCount('.col_right .story', 30);
        $this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('210'));
        $this->client->assertResponseSelectEquals('h3.story', array('_text'), array('Smoke in the water'));
    }

    public function testScheduleDefault()
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
        $this->client->assertResponseSelectCount('.col_left .story', 13);
        $this->client->assertResponseSelectCount('.col_right .story', 31);
        $this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('220'));
        $this->client->assertResponseSelectEquals('h3.story', array('_text'), array('Danse on a volcano'));
        $this->client->assertResponseSelectEquals('.col_right ol li:first-child .status_todo', array('_text'), array('Smoke in the water'));
    }

    public function testSchedulePending()
    {
        $crawler = $this->client->request('GET', '/sprint/schedule');

        $form = $crawler->filter('#addStoryPending')->form();
        $this->client->submit($form, array(
        ));
        $this->client->followRedirect();
        
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:schedule');

        $this->addResponseTester();
        $this->client->assertResponseSelectCount('.col_left .story', 13);
        $this->client->assertResponseSelectCount('.col_right .story', 31);
        $this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('220'));
        $this->client->assertResponseSelectEquals('h3.story', array('_text'), array('Danse on a volcano'));
        $this->client->assertResponseSelectEquals('.col_right ol li:first-child .status_pending', array('_text'), array('Smoke in the water'));
    }

}
