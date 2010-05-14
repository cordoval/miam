<?php

namespace Bundle\MiamBundle\Tests;

require_once 'PHPUnit/Framework.php';
require_once __DIR__.'/Functional/createAStoryTest.php';
require_once __DIR__.'/Functional/showAStoryTest.php';
require_once __DIR__.'/Functional/editAStoryTest.php';

class AllTests
{
  public static function suite()
  {
    $suite = new \PHPUnit_Framework_TestSuite('MiamBundle_Functional');

    $suite->addTestSuite('Miam\Tests\Functional\showAStoryTest');
    $suite->addTestSuite('Miam\Tests\Functional\createAStoryTest');
    $suite->addTestSuite('Miam\Tests\Functional\editAStoryTest');

    return $suite;
  }
}