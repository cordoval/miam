<?php

namespace Miam\Tests\Functional;

use Bundle\PHPUnitBundle\Functional;

class noSprintAvailableTest extends \WebTestCase
{
    
    public function testCreateASprintAutomatically()
    {
        $this->getContainer()->getDoctrine_Orm_DefaultEntityManagerService()
            ->getRepository('Bundle\MiamBundle\Entities\Sprint')
            ->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->execute();
        
        $crawler = $this->client->request('GET', '/sprint');

        $this->client->followRedirect();

        $this->addRequestTester();
        $this->client->assertRequestParameter('_route', 'sprint_new');
        $this->client->assertRequestParameter('_controller', 'MiamBundle:Sprint:new');
   }

}
