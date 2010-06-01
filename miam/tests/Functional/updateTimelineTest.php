<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class UpdateTimelineTest extends \WebTestCase
{
    
    public function testCreateStoryUpdatesTimeline()
    {
        $this->login('thib');
        $crawler = $this->client->request('GET', '/story/new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'bluk'
        ));
        
        $crawler = $this->client->request('GET', '/timeline');
        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry .tentry_user', array('_text'), array('thib', 'thib', 'matt'));
        $this->client->assertResponseSelectEquals('.tentry ', array('_text'), array(sprintf('thib a créé bluk [Miam] à %s', date('H:i')), 'thib a commenté Danse on a volcano [Miam] à 16:02', 'matt a créé Smoke in the water [Miam] à 15:00'));
    }

    protected function login($username)
    {
        $crawler = $this->client->request('GET', '/user/login');

        $form = $crawler->selectButton('Log in')->form();
        $this->client->submit($form, array(
            'username' => $username,
            'password' => 'changeme'
        ));


        $this->client->followRedirect();
        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('div.auth span.username', array('_text'), array($username));
    }

}
