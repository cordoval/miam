<?php

namespace Bundle\MiamBundle\Tests;

require_once 'PHPUnit/Framework.php';
require_once __DIR__.'/Entities/StoryTest.php';

class AllTests
{
  public static function suite()
  {
    $suite = new \PHPUnit_Framework_TestSuite('MiamBundle');

    $suite->addTestSuite('\Bundle\MiamBundle\Tests\Entities\StoryTest');

    return $suite;
  }
}