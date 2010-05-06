<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Bundle\MiamBundle\Entities\Story;
use Bundle\MiamBundle\Renderer\StoryRenderer;

class MiamController extends Controller
{

    public function indexAction()
    {
        $stories = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->findAllOrderByPriority();

        $storyRenderer = new StoryRenderer($this->container->getRouterService());

        return $this->render('MiamBundle:Miam:index', array(
            'stories' => $stories,
            'storiesRenderer' => $storyRenderer,
        ));
    }

    public function showAction($id)
    {
        $story = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->find($id);

        if (!$story)
        {
            throw new NotFoundHttpException("Story not found");
        }

        return $this->render('MiamBundle:Miam:show', array(
            'story' => $story,
            'decorate' => $this->getRequest()->isXmlHttpRequest()
        ));
    }

}