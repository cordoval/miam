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

}
