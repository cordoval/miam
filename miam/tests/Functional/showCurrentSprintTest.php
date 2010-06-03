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
        $this->client->assertResponseSelectEquals('h1.sprint', array('_text'), array('Backlog de Sprint'));
        $this->client->assertResponseSelectEquals('span.finished', array('_text'), array('0/210'));

        $this->client->assertResponseSelectEquals('th.status_pending', array('_text'), array('En attente (30)'));
        $this->client->assertResponseSelectEquals('th.status_todo', array('_text'), array('A faire (70)'));
        $this->client->assertResponseSelectEquals('th.status_wip', array('_text'), array('En cours (110)'));
        $this->client->assertResponseSelectEquals('th.status_finished', array('_text'), array('Fait (0)'));
    }

}
