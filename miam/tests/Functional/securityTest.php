<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class securityTest extends \WebTestCase
{
    
    public function testAnonymousUserMustLogin()
    {
        $crawler = $this->client->request('GET', '/');

        $this->addResponseTester();
        $this->client->assertResponseRegExp('/Tu n\'es pas connecté/');
    }

    public function testLogin()
    {
        $this->login('thib', 'changeme');

        $this->addResponseTester();
        $this->client->assertResponseRegExp('/Hello, thib!/');
    }

    public function testLogout()
    {
        $crawler = $this->client->request('GET', '/user/logout');
        $this->client->followRedirect();
        $this->addResponseTester();
        $this->client->assertResponseRegExp('/Tu n\'es pas connecté/');
    }

    public function testFastLogin()
    {
        $crawler = $this->client->request('GET', '/');
        $this->addResponseTester();
        $this->client->assertResponseRegExp('/Tu n\'es pas connecté/');
        $this->client->click($crawler->selectLink('thib')->link());
        $this->addResponseTester();
        $this->client->assertResponseNotRegExp('/Tu n\'es pas connecté/');
    }
}
