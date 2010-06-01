<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class showTheTimelineTest extends \WebTestCase
{
    
    public function testShow()
    {
        $crawler = $this->client->request('GET', '/timeline');
        $this->client->assertResponseSelectEquals('.tentry .tentry_user', array('_text'), array('thib', 'matt'));
        $this->client->assertResponseSelectEquals('.tentry ', array('_text'), array('thib a commenté Danse on a volcano [Miam] à 16:02', 'matt a créé Smoke in the water [Miam] à 15:00'));
    }

}
