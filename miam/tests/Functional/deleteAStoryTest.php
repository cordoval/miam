<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class deleteAStoryTest extends \WebTestCase
{
    
    public function testDeleteAStoryRemovesItFromTheBacklog()
    {
        $this->login('laet', 'changeme');

        $crawler = $this->client->request('GET', '/');
        $this->addResponseTester();
        $this->client->assertResponseRegExp('#Smoke in the water</a>#');
        $this->client->click($crawler->selectLink('Smoke in the water')->link());
        
        $crawler = $this->client->getCrawler();
        $this->client->click($crawler->selectLink('Supprimer')->link());

        $crawler = $this->client->getCrawler();
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'story_delete');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Story:delete');

        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');
        
        // flash message
        $this->addResponseTester();
        $this->client->assertResponseRegExp('/Smoke in the water/');
        $this->client->assertResponseNotRegExp('/Smoke in the water<\/a>/');
        if($this->testFlashes) {
            $this->client->assertResponseSelectEquals('.flash_info', array('_text'), array('/La story <b>"Smoke in the water"<\/b> a été supprimée'));
        }
    }
    
    public function testDeleteAStoryRemovesItFromTheSprint()
    {
        //$this->login('laet', 'changeme');

        //$crawler = $this->client->request('GET', '/sprint/schedule');
        //$form = $crawler->filter('#addStory')->form();
        //$this->client->submit($form, array(
        //));
        //$this->client->followRedirect();

        //$crawler = $this->client->request('GET', '/');
        //$this->client->click($crawler->selectLink('Smoke in the water')->link());

        //$crawler = $this->client->click($crawler->selectLink('Supprimer')->link());
        //$this->addRequestTester();
        //$this->client->assertRequestParameter('_route', 'story_delete');
        //$this->client->assertRequestParameter('_controller', 'MiamBundle:Story:delete');
        //$this->client->followRedirect();

        //$crawler = $this->client->request('GET', '/');
        //$this->addResponseTester();
    }

}
