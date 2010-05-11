<?php

namespace Bundle\MiamBundle\Tests;

require_once 'PHPUnit/Framework.php';
require_once __DIR__.'/Entity/StoryTest.php';
require_once __DIR__.'/Renderer/StoryRendererTest.php';

class AllTests
{
  public static function suite()
  {
    $suite = new \PHPUnit_Framework_TestSuite('MiamBundle');

    // Unit
    $suite->addTestSuite('\Bundle\MiamBundle\Tests\Entities\StoryTest');
    $suite->addTestSuite('\Bundle\MiamBundle\Tests\Renderer\StoryRendererTest');

    // Functional
    $suite->addTestSuite('\Bundle\MiamBundle\Tests\Functional\createAStoryTest');

    return $suite;
  }
}