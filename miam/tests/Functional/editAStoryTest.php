<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class editAStoryTest extends \WebTestCase
{
    
    public function testEditAStoryShowsItOnTheBacklog()
    {
        $this->login('thib', 'changeme');
        $crawler = $this->client->request('GET', '/sprint/schedule');
        $this->client->click($crawler->selectLink('Smoke in the water')->link());
        
        $crawler = $this->client->getCrawler();
        $this->client->click($crawler->selectLink('Modifier')->link());

        $crawler = $this->client->getCrawler();
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'story_edit');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Story:edit');

        $form = $crawler->filter('#submit')->form();
        // Equivalent to 
        // $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'Edited you',
            'story[body]' => 'lorem',
            'story[points]' => '12'
        ));
        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_schedule');
        
        $this->addResponseTester();
        // echo $this->client->getResponse()->getContent();
        
        $this->client->assertResponseRegExp('/Edited you/');
        if($this->testFlashes) {
            $this->client->assertResponseSelectEquals('.flash_info', array('_text'), array('/La story <b>"Edited you"<\/b> a été mise à jour/'));
        }
        
    }

}
