<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class editAStoryTest extends \WebTestCase
{
    
    public function testEditAStoryShowsItOnTheBacklog()
    {
        $crawler = $this->client->request('GET', '/');
        $this->client->click($crawler->selectLink('#1 − Smoke in the water')->link());
        
        $crawler = $this->client->getCrawler();
        $this->client->click($crawler->selectLink('Modifier')->link());

        $crawler = $this->client->getCrawler();
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'story_edit');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Miam:edit');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'Edited you',
            'story[body]' => 'lorem',
            'story[points]' => '12'
        ));
        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'backlog');
        
        $this->addResponseTester();
        $this->client->assertResponseRegExp('/Edited you/');
    }


}