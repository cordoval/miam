<?php

use Bundle\PHPUnitBundle\Functional\WebTestCase as BaseWebTestCase;

use Bundle\PHPUnitBundle\Functional\Service\BackupSqliteService;

/**
 * Extend the genereric TestCase with projet-specific objects (Kernel…)
 *
 */
class WebTestCase extends BaseWebTestCase
{
    protected $testFlashes = false;
    protected $kernel;
    
    protected function buildFunctionalServices()
    {
        if(!$this->hasService('backup_sqlite')) {
            $params = $this->kernel->getContainer()->getService('doctrine.dbal.default_connection')->getParams();

            $this->functionalServices['backup_sqlite'] = new BackupSqliteService($this, array(
                'database_path' => $params['path'],
            ));
        }
    }
    
    /**
     * Creates a Kernel.
     *
     * @return Symfony\Foundation\Kernel A Kernel instance
     */
    protected function createKernel()
    {
        return $this->kernel = new \MiamKernel('test', true);
    }
 
    protected function debugOutput()
    {
        die($this->client->getResponse()->getContent());
    }
}