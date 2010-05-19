<?php

namespace Bundle\PHPUnitBundle\Functional;

use Doctrine\Common\EventManager;
use Doctrine\Common\EventArgs;

abstract class WebSqliteTestCase extends WebTestCase
{
    public function getDatabasePath()
    {
        return '/tmp/miam.sqlite';
    }

    public function getDatabaseBackupPath()
    {
        return $this->getDatabasePath().'.bak';
    }
    
    public function setUp()
    {
        parent::setUp();
        copy($this->getDatabasePath(), $this->getDatabaseBackupPath());
    }
    
    public function tearDown()
    {
        parent::tearDown();
        copy($this->getDatabaseBackupPath(), $this->getDatabasePath());
    }
}
