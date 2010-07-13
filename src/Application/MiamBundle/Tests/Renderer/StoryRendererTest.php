<?php

namespace Application\MiamBundle\Tests\Renderer;

use Application\MiamBundle\Renderer\StoryRenderer,
    Symfony\Components\Routing\RouterInterface;

require_once 'PHPUnit/Framework.php';
require_once __DIR__.'/../../Renderer/StoryRenderer.php';

class StoryRendererTest extends \PHPUnit_Framework_TestCase
{
  protected function mockStory($id)
  {
    $story = $this->getMock('Story', array(
        'getId',
        'getName',
        'getBody',
        'getCreatedAt',
        'getPriority',
      ));

    $story->expects($this->any())->method('getId')->will($this->returnValue($id));
    $story->expects($this->any())->method('getName')->will($this->returnValue('n'));
    $story->expects($this->any())->method('getBody')->will($this->returnValue('b'));
    $story->expects($this->any())->method('getCreatedAt')->will($this->returnValue('c'));
    $story->expects($this->any())->method('getPriority')->will($this->returnValue('p'));
    return $story;
  }
  
  public function testRenderStoriesAsJson()
  {
    $router = $this->getMock('RouterInterface', array(
      'generate',
    ));
    $router->expects($this->any())->method('generate')->will($this->returnValue('url'));
    
    $renderer = new StoryRenderer($router);

    $stories = array($this->mockStory(1), $this->mockStory('ab'));
    
    $this->assertEquals('{}', $renderer->renderStoriesAsJson(array()), '->renderStoriesAsJson(array()) returns a json empty object');
    $this->assertEquals('{"1":{"id":1,"name":"n","body":"b","createdAt":"c","priority":"p","url_show":"url"},"ab":{"id":"ab","name":"n","body":"b","createdAt":"c","priority":"p","url_show":"url"}}', $renderer->renderStoriesAsJson($stories), '->renderStoriesAsJson() returns a json object');
  }

}
