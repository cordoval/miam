<?php

namespace Bundle\MiamBundle\Renderer;

use Bundle\MiamBundle\Entities;

/**
 * Render a story or an array of stories.
 *
 * @package    MiamBundle
 * @subpackage Renderer
 * @author     Matthieu Bontemps <matthieu.bontemps@gmail.com>
 */
class StoryRenderer
{
    protected $router;

    function __construct($router)
    {
        $this->router = $router;
    }

    public function renderStoriesAsJson(array $stories)
    {
        $public = array();
        foreach ($stories as $story)
        {
            $public[$story->getId()] = array(
                'id' => $story->getId(),
                'name' => $story->getName(),
                'body' => $story->getBody(),
                'createdAt' => $story->getCreatedAt(),
                'priority' => $story->getPriority(),
                'url_show' => $this->router->generate('story', array('id' => $story->getId())),
            );
        }
        return json_encode($public, JSON_FORCE_OBJECT);
    }

}
