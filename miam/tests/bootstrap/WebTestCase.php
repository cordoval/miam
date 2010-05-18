<?php

use Bundle\PHPUnitBundle\Functional\WebDoctrineTestCase as BaseWebTestCase;

/**
 * Extend the genereric TestCase with projet-specific objects (Kernel…)
 *
 */
class WebTestCase extends BaseWebTestCase
{
    protected $testFlashes = false;
    protected $kernel;
    
    /**
     * Creates a Kernel.
     *
     * @return Symfony\Foundation\Kernel A Kernel instance
     */
    protected function createKernel()
    {
        return $this->kernel = new \MiamKernel('test', true);
    }
    
}