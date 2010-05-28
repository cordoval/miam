<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class deleteAStoryTest extends \WebTestCase
{
    
    public function testDeleteAStoryRemovesItFromTheBacklog()
    {
        $crawler = $this->client->request('GET', '/');
        $this->client->click($crawler->selectLink('Smoke in the water')->link());
        
        $crawler = $this->client->getCrawler();
        $this->client->click($crawler->selectLink('Supprimer')->link());

        $crawler = $this->client->getCrawler();
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'story_delete');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Story:delete');

        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'backlog');
        
        $this->client->assertResponseNotRegExp('/Smoke in the water/');
        if($this->testFlashes) {
            $this->client->assertResponseSelectEquals('.flash_info', array('_text'), array('/La story <b>"Smoke in the water"<\/b> a été supprimée'));
        }
        
    }

}
