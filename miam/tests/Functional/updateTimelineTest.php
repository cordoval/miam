<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class UpdateTimelineTest extends \WebTestCase
{
    
    public function testCreateProjectUpdatesTimeline()
    {
        $crawler = $this->client->request('GET', '/project/new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'project[name]' => 'bluk',
            'project[color]' => '#00FF00',
        ));
        
        $crawler = $this->client->request('GET', '/timeline');
        $this->client->assertResponseSelectEquals('.tentry .tentry_user', array('_text'), array('thib', 'matt'));
        $this->client->assertResponseSelectEquals('.tentry ', array('_text'), array('thib a commenté Danse on a volcano [Miam] à 16:02', 'matt a créé Smoke in the water [Miam] à 15:00'));
    }

}
