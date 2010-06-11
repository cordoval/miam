<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;
use Bundle\MiamBundle\Entities\Story;
use Bundle\MiamBundle\Entities\TimelineEntry;

class UpdateTimelineTest extends \WebTestCase
{
    public function testScheduleStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        
        $crawler = $this->client->request('GET', '/sprint/schedule');

        //$form = $crawler->selectButton('Ajouter au sprint →')->form();
        //$this->client->submit($form, array());

        //$crawler = $this->client->request('GET', '/');

        //$this->addResponseTester();
        //$this->client->assertResponseSelectEquals('.tentry.first.action_'.TimelineEntry::ACTION_SCHEDULE.' .tentry_user', array('_text'), array('laet'));
    }

    public function testChangeStoryStatusUpdatesTimeline()
    {
        $this->login('laet', 'changeme');

        $crawler = $this->client->request('GET', '/');

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

            $crawler = $this->client->request('GET', '/');

            $this->addResponseTester();
            $action = TimelineEntry::getActionForStoryStatus($status);
            $this->client->assertResponseSelectEquals('.tentry.first.action_'.$action.' .tentry_user', array('_text'), array('laet'));
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
        
        $crawler = $this->client->request('GET', '/');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first.action_'.TimelineEntry::ACTION_CREATE.' .tentry_user', array('_text'), array('laet'));
    }
    
    public function testEstimateStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        $crawler = $this->client->request('GET', '/story/new');

        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'bluk'
        ));
        
        $crawler = $this->client->request('GET', '/sprint/schedule');
        
        $crawler = $this->client->click($crawler->selectLink('bluk')->link());
        $crawler = $this->client->click($crawler->selectLink('Modifier')->link());
        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'bluk',
            'story[points]' => 100
        ));
        $crawler = $this->client->request('GET', '/');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first.action_'.TimelineEntry::ACTION_ESTIMATE.' .tentry_user', array('_text'), array('laet'));
    }
 
    public function testReestimateStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        
        $crawler = $this->client->request('GET', '/sprint/schedule');
        
        $crawler = $this->client->click($crawler->selectLink('Smoke in the water')->link());
        $crawler = $this->client->click($crawler->selectLink('Modifier')->link());
        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'Smoke in the water',
            'story[points]' => 100
        ));
        $crawler = $this->client->request('GET', '/');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first.action_'.TimelineEntry::ACTION_REESTIMATE.' .tentry_user', array('_text'), array('laet'));
    }
  
    public function testReestimateStoryFromSprintUpdatesTimeline()
    {
        $this->login('laet', 'changeme');

        $crawler = $this->client->request('GET', '/');

        $firstStoryId = $crawler->filter('#sprintBacklog div.story')->attr('data-story-id');

        $crawler = $this->client->request('POST', '/story/reestimate', array(
            'story_id' => $firstStoryId,
            'points' => 100
        ));

        $crawler = $this->client->request('GET', '/');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first.action_'.TimelineEntry::ACTION_REESTIMATE.' .tentry_user', array('_text'), array('laet'));
    }
 
    public function testEditStoryUpdatesTimeline()
    {
        $this->login('laet', 'changeme');
        
        $crawler = $this->client->request('GET', '/sprint/schedule');
        
        $crawler = $this->client->click($crawler->selectLink('Smoke in the water')->link());
        $crawler = $this->client->click($crawler->selectLink('Modifier')->link());
        $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'story[name]' => 'Water in the smoke',
            'story[points]' => 10
        ));
        $crawler = $this->client->request('GET', '/');

        $this->addResponseTester();
        $this->client->assertResponseSelectEquals('.tentry.first.action_'.TimelineEntry::ACTION_EDIT.' .tentry_user', array('_text'), array('laet'));
    }

}
