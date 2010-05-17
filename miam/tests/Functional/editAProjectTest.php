<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class editAProjectTest extends \WebTestCase
{
    
    public function testEditAProjectShowsItOnTheBacklog()
    {
        $crawler = $this->client->request('GET', '/projects');
        $this->client->click($crawler->selectLink('Miam')->link());
        
        $crawler = $this->client->getCrawler();
        $this->client->click($crawler->selectLink('Modifier')->link());

        $crawler = $this->client->getCrawler();
        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'project_edit');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Project:edit');

        $form = $crawler->filter('#submit')->form();
        // Equivalent to 
        // $form = $crawler->selectButton('Valider')->form();
        $this->client->submit($form, array(
            'project[name]' => 'Edited you',
        ));
        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'projects');
        
        // echo $this->client->getResponse()->getContent();
        
        $this->client->assertResponseRegExp('/Edited you/');
        if($this->testFlashes) {
            $this->client->assertResponseSelectEquals('.flash_info', array('_text'), array('/Le projet <em>"Edited you"<\/em> a été mis à jour/'));
        }
        
    }

}