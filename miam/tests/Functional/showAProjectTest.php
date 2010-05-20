<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class showAProjectTest extends \WebTestCase
{
    
    public function testShowAProject()
    {
        $crawler = $this->client->request('GET', '/projects');
        $this->client->click($crawler->selectLink('Miam')->link());

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'project');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Project:show');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('h1.project', array('_text'), array('Backlog de Miam'));
    }

}