<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class UpdateTimelineTest extends \WebTestCase
{
    
    public function testCreateStoryUpdatesTimeline()
    {
        $this->login('thib', 'changeme');
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
}
