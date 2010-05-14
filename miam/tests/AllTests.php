<?php

namespace Bundle\MiamBundle\Tests;

require_once 'PHPUnit/Framework.php';
require_once __DIR__.'/Functional/createAStoryTest.php';

class AllTests
{
  public static function suite()
  {
    $suite = new \PHPUnit_Framework_TestSuite('MiamBundle_Functional');

    $suite->addTestSuite('Miam\Tests\Functional\createAStoryTest');

    return $suite;
  }
}