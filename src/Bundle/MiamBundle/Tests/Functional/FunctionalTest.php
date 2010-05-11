<?php

namespace Bundle\MiamBundle\Tests\Functional;

require_once __DIR__ . '/../bootstrap/functional.php';
require_once __DIR__ . '/../../../../../miam/MiamKernel.php';

use Symfony\Components\HttpKernel\Test\Client,
    Symfony\Components\HttpKernel\Test\RequestTester,
    Symfony\Components\HttpKernel\Test\ResponseTester
;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    protected $client;
    
    public function setUp()
    {
        $kernel = new \MiamKernel('test', true);
        $kernel->boot();

        $httpKernel = $kernel->getContainer()->getHttpKernelService();
        $this->client = new Client($httpKernel);
        $this->client->setTestCase($this);
    }
    
    protected function addRequestTester()
    {
        $this->client->addTester('request', new RequestTester($this->client->getRequest()));
    }
}
