<?php

namespace Bundle\MiamBundle\Tests\Entity;

use Bundle\MiamBundle\Entity\Story;

require_once 'PHPUnit/Framework.php';
require_once __DIR__.'/../../Entity/Story.php';

class StoryTest extends \PHPUnit_Framework_TestCase
{
  public function testCreatedAtSetOnConstruction()
  {
    $story = new Story();
    $this->assertTrue($story->getCreatedAt() instanceof \DateTime);
  }

  public function testSetAndGetName()
  {
    $story = new Story();
    $story->setName('Once upon a time...');
    $this->assertEquals('Once upon a time...', $story->getName());
  }

  public function testGetId()
  {
    $story = new Story();
    $this->assertTrue(is_null($story->getId()));
  }
}