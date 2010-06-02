<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class createASprintTest extends \WebTestCase
{
 
    public function testFormValidation()
    {
        $crawler = $this->client->request('GET', '/sprint/new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
        ));

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_new');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:new');

        $this->addResponseTester();
        $this->client->assertResponseRegExp('/This value should not be null/');
    }
   
    public function testCreateASprintShowsItOnTheBacklog()
    {
        $crawler = $this->client->request('GET', '/sprint/new');

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_new');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'sprint[startsAt][day]' => 25,
            'sprint[startsAt][month]' => 5,
            'sprint[startsAt][year]' => 2010,

            'sprint[endsAt][day]' => 28,
            'sprint[endsAt][month]' => 5,
            'sprint[endsAt][year]' => 2010,
        ));
        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');

        if($this->testFlashes) {
            $this->client->assertResponseRegExp('/Le sprint/');
        }
   }

}
