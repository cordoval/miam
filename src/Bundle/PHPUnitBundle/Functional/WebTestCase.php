<?php

namespace Bundle\PHPUnitBundle\Functional;

use Symfony\Foundation\Test\WebTestCase as BaseWebTestCase;
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

        $client = $kernel->getContainer()->getTest_ClientService();
        $client->setServerParameters($server);
        $client->setTestCase($this);
        
        return $client;
    }

    public function setUp()
    {
        $this->client = $this->createClient();
    }
    
    /**
     * Add a request tester to the current client associated to its request
     *
     * @return $this
     */
    protected function addRequestTester()
    {
        $this->client->addTester('request', new RequestTester($this->client->getRequest()));
        return $this;
    }
    
    /**
     * Add a response tester to the current client associated to its response
     *
     * @return $this
     */
    protected function addResponseTester()
    {
        $this->client->addTester('response', new ResponseTester($this->client->getResponse()));
        return $this;
    }
    
}
