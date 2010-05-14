<?php

namespace Bundle\PHPUnitBundle\Functional;

use Symfony\Foundation\Test\WebTestCase as BaseWebTestCase;
// use Symfony\Components\HttpKernel\Test\Client;
use Symfony\Foundation\Test\Client;
use Symfony\Components\HttpKernel\Test\RequestTester;
use Symfony\Components\HttpKernel\Test\ResponseTester;

abstract class WebTestCase extends BaseWebTestCase
{
    protected $client;

    /**
     * Creates a Client.
     *
     * @return Symfony\Foundation\Test\Client A Client instance
     */
    public function createClient(array $server = array())
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        // $httpKernel = $kernel->getContainer()->getHttpKernelService();
        $client = $kernel->getContainer()->getTest_ClientService();
        // $client = new Client($kernel);
        $client->setServerParameters($server);
        $client->setTestCase($this);
        
        return $client;
    }

    public function setUp()
    {
        $this->client = $this->createClient();
    }
    
    
    protected function addRequestTester()
    {
        $this->client->addTester('request', new RequestTester($this->client->getRequest()));
    }
}
