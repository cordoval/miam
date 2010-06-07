<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class showAStoryTest extends \WebTestCase
{
    
    public function testShowAStory()
    {
        $crawler = $this->client->request('GET', '/');
        $this->client->click($crawler->selectLink('Smoke in the water')->link());

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'story');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Story:show');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.story_title', array('_text'), array('Smoke in the water'));
    }

}
