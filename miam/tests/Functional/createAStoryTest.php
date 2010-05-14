<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class createAStoryTest extends \WebTestCase
{
    
    public function testCreateAStoryShowsItOnTheBacklog()
    {
      $crawler = $this->client->request('GET', '/story/new');
      
      $this->addRequestTester();
      $this->client->assertRequestParameter('_route', 'story_new');
      $this->client->assertRequestParameter('_controller', 'MiamBundle:Miam:new');
      
      $form = $crawler->selectButton('Valider')->form();
      $this->client->submit($form, array(
          'story[name]' => 'My story morning glory',
          'story[body]' => 'lorem',
          'story[points]' => '12'
      ));
      $this->client->followRedirect();
      
      $this->addRequestTester();
      $this->client->assertRequestParameter('_route', 'backlog');
      
      $this->addResponseTester();
      $this->client->assertResponseRegExp('/My story morning glory/');
    }

}