<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class showAStoryTest extends \WebTestCase
{
    
    public function testShowAStory()
    {
        $crawler = $this->client->request('GET', '/');
        $this->client->click($crawler->selectLink('#1 − Smoke in the water')->link());

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'story');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Story:show');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('h1.story', array('_text'), array('Smoke in the water'));
    }

}