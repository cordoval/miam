<?php

use Bundle\PHPUnitBundle\Functional\WebTestCase as BaseWebTestCase;

/**
 * Extend the genereric TestCase with projet-specific objects (Kernel…)
 *
 */
class WebTestCase extends BaseWebTestCase
{
    protected $testFlashes = false;
    
    /**
     * Creates a Kernel.
     *
     * @return Symfony\Foundation\Kernel A Kernel instance
     */
    protected function createKernel()
    {
        return $kernel = new \MiamKernel('test', true);
    }
    
}