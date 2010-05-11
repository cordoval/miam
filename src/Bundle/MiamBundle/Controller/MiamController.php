<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Bundle\MiamBundle\Entities\Story;
use Bundle\MiamBundle\Renderer\StoryRenderer;
use Bundle\MiamBundle\Form\StoryForm;

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

    public function sortAction()
    {
        $ids = $this->getRequest()->request->get('story');

        $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->sort($ids);

        $this->getEntityManager()->flush();

        return $this->createResponse('done');
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

    public function newAction()
    {
        $em = $this->getEntityManager();
        $form = new StoryForm($em, null);

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get($form->getName()));

            if($form->isValid()) {
                $form->updateObject();
                $em->persist($form->getObject());
                $em->flush();
                return $this->redirect($this->generateUrl('backlog'));
            }
            
        }

        return $this->render('MiamBundle:Miam:new', array(
            'form' => $form
        ));
    }

    
}