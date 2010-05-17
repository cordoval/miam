<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class createAProjectTest extends \WebTestCase
{
    
    public function testCreateAProjectShowsItOnTheBacklog()
    {
      $crawler = $this->client->request('GET', '/project/new');
      
      $this->addRequestTester();
      $this->client->assertRequestParameter('_route', 'project_new');
      $this->client->assertRequestParameter('_controller', 'MiamBundle:Project:new');
      
      $form = $crawler->selectButton('Valider')->form();
      $this->client->submit($form, array(
          'project[name]' => 'Life',
      ));
      $this->client->followRedirect();
      
      $this->addRequestTester();
      $this->client->assertRequestParameter('_route', 'projects');
      
      $this->addResponseTester();
      $this->client->assertResponseRegExp('/Life<\/a>/');
      if($this->testFlashes) {
          $this->client->assertResponseRegExp('/au backlog/');
      }
    }

}