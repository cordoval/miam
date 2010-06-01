<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;
use Bundle\MiamBundle\Entities\Story;

class UpdateTimelineTest extends \WebTestCase
{
    public function testScheduleStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');

        $crawler = $this->client->request('GET', '/sprint/schedule');

        $form = $crawler->selectButton('Ajouter au sprint →')->form();
        $this->client->submit($form, array());

        $crawler = $this->client->request('GET', '/timeline');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first .tentry_user', array('_text'), array('laet'));
        $this->client->assertResponseSelectEquals('.tentry.first', array('_text'), array(sprintf('laet a ajouté Smoke in the water [Miam] au sprint à %s', date('H:i'))));
    }

    public function testChangeStoryStatusUpdatesTimeline()
    {
        $this->login('laet', 'changeme');

        $crawler = $this->client->request('GET', '/sprint');

        $firstStoryId = $crawler->filter('#sprintBacklog div.story')->attr('data-story-id');

        $this->assertTrue(!empty($firstStoryId));

        $matches = array(
            Story::STATUS_WIP => 'laet a commencé à travailler sur Lister les ballades prévues [project_1] à %s',
            Story::STATUS_TODO => 'laet a passé Lister les ballades prévues [project_1] dans l\'état À FAIRE à %s',
            Story::STATUS_FINISHED => 'laet a fini Lister les ballades prévues [project_1] à %s',
            Story::STATUS_PENDING => 'laet a passé Lister les ballades prévues [project_1] dans l\'état EN ATTENTE à %s'
        );

        foreach($matches as $status => $tentry) {
            $this->client->request('POST', '/story/move', array(
                'status' => $status,
                'story_id' => $firstStoryId
            ));
            $this->addResponseTester();

            $crawler = $this->client->request('GET', '/timeline');

            $this->addResponseTester();
            $this->client->assertResponseSelectEquals('.tentry.first', array('_text'), array(sprintf($tentry, date('H:i'))));
            $this->client->assertResponseSelectEquals('.tentry.first .tentry_user', array('_text'), array('laet'));
        }
    }
   
    public function testCreateStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        $crawler = $this->client->request('GET', '/story/new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'bluk'
        ));
        
        $crawler = $this->client->request('GET', '/timeline');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry .tentry_user', array('_text'), array('laet', 'thib', 'matt'));
        $this->client->assertResponseSelectEquals('.tentry ', array('_text'), array(sprintf('laet a créé bluk [Miam] à %s', date('H:i')), 'thib a commenté Danse on a volcano [Miam] à 16:02', 'matt a créé Smoke in the water [Miam] à 15:00'));

        $this->client->assertResponseSelectEquals('.tentry.first .tentry_user', array('_text'), array('laet'));
        $this->client->assertResponseSelectEquals('.tentry.first', array('_text'), array(sprintf('laet a créé bluk [Miam] à %s', date('H:i'))));
    }
    
    public function testEstimateStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        $crawler = $this->client->request('GET', '/story/new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'bluk'
        ));
        
        $crawler = $this->client->request('GET', '/');
        
        $crawler = $this->client->click($crawler->selectLink('bluk')->link());
        $crawler = $this->client->click($crawler->selectLink('Modifier')->link());
        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'bluk',
            'story[points]' => 100
        ));
        $crawler = $this->client->request('GET', '/timeline');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first .tentry_user', array('_text'), array('laet'));
        $this->client->assertResponseSelectEquals('.tentry.first', array('_text'), array(sprintf('laet a estimé bluk [Miam] à 100 points à %s', date('H:i'))));
    }
 
    public function testReestimateStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        
        $crawler = $this->client->request('GET', '/');
        
        $crawler = $this->client->click($crawler->selectLink('Smoke in the water')->link());
        $crawler = $this->client->click($crawler->selectLink('Modifier')->link());
        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'Smoke in the water',
            'story[points]' => 100
        ));
        $crawler = $this->client->request('GET', '/timeline');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first .tentry_user', array('_text'), array('laet'));
        $this->client->assertResponseSelectEquals('.tentry.first', array('_text'), array(sprintf('laet a réestimé Smoke in the water [Miam] à 100 points à %s', date('H:i'))));
    }
  
    public function testReestimateStoryFromSprintUpdatesTimeline()
    {
        $this->login('laet', 'changeme');

        $crawler = $this->client->request('GET', '/sprint');

        $firstStoryId = $crawler->filter('#sprintBacklog div.story')->attr('data-story-id');

        $crawler = $this->client->request('POST', '/story/reestimate', array(
            'story_id' => $firstStoryId,
            'points' => 100
        ));

        $crawler = $this->client->request('GET', '/timeline');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first .tentry_user', array('_text'), array('laet'));
        $this->client->assertResponseSelectEquals('.tentry.first', array('_text'), array(sprintf('laet a réestimé Lister les ballades prévues [project_1] à 100 points à %s', date('H:i'))));
    }
 
    public function testEditStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        
        $crawler = $this->client->request('GET', '/');
        
        $crawler = $this->client->click($crawler->selectLink('Smoke in the water')->link());
        $crawler = $this->client->click($crawler->selectLink('Modifier')->link());
        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'Water in the smoke',
            'story[points]' => 10
        ));
        $crawler = $this->client->request('GET', '/timeline');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first .tentry_user', array('_text'), array('laet'));
        $this->client->assertResponseSelectEquals('.tentry.first', array('_text'), array(sprintf('laet a mis à jour Water in the smoke [Miam] à %s', date('H:i'))));
    }

}
