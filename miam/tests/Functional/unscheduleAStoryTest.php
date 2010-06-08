<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class unscheduleAStoryTest extends \WebTestCase
{
    
    public function testUnschedule()
    {
        $this->login('laet', 'changeme');

        $crawler = $this->client->request('GET', '/sprint/schedule');
        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.story_planCard .story_name', array('_text'), array('Smoke in the water'));
        $this->client->assertResponseSelectCount('.col_left .story', 14);
        $this->client->assertResponseSelectCount('.col_right .story', 30);
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
        $crawler = $this->client->click($crawler->selectLink('Smoke in the water')->link());
        $this->addResponseTester();

        /**
         * It seems that the crawler badly handles ajax responses, without <html> nor <body> elements
         */

        //$crawler = $this->client->click($crawler->selectLink('Déplanifier')->link());
        //$this->client->followRedirect();
        
        //$this->addRequestTester();
        //$this->client->assertRequestParameter('_route', 'sprint_schedule');
        //$this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:schedule');
        //$this->addResponseTester();
        //$this->client->assertResponseSelectCount('.col_left .story', 14);
        //$this->client->assertResponseSelectCount('.col_right .story', 30);
        //$this->client->assertResponseSelectEquals('#sprint_points', array('_text'), array('205'));
        //$this->client->assertResponseSelectEquals('.story_planCard .story_name', array('_text'), array('Smoke in the water'));
    }

}
