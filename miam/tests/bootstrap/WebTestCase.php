<?php

use Bundle\PHPUnitBundle\Functional\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
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