<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class createASprintTest extends \WebTestCase
{
    
    public function testCreateASprintShowsItOnTheBacklog()
    {
        $crawler = $this->client->request('GET', '/sprint/new');

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_new');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'sprint[starts_at][day]' => 25,
            'sprint[starts_at][month]' => 5,
            'sprint[starts_at][year]' => 2010,

            'sprint[ends_at][day]' => 28,
            'sprint[ends_at][month]' => 5,
            'sprint[ends_at][year]' => 2010,
        ));
        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');

        if($this->testFlashes) {
            $this->client->assertResponseRegExp('/Le sprint/');
        }
   }

}