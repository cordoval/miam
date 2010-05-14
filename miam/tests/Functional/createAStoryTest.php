<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class createAStoryTest extends \WebTestCase
{
    
    public function testCreateForm()
    {
      $crawler = $this->client->request('GET', '/story/new');
      // echo $this->client->getResponse()->getContent();
      
      $this->addRequestTester();
      $this->client->assertRequestParameter('_controller', 'Miam');
      $this->client->assertRequestParameter('_action', 'new');
      // echo $this->client->getResponse()->getContent();
      
      $form = $crawler->selectButton('Valider')->form();
      $this->client->submit($form, array(
          'story[name]' => 'My story morning glory',
          'story[body]' => 'lorem',
          'story[points]' => '12'
      ));
      $this->client->followRedirect();
      
    }

}