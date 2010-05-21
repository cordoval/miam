<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Bundle\MiamBundle\Entities\Story;
use Bundle\MiamBundle\Renderer\StoryRenderer;
use Bundle\MiamBundle\Form\StoryForm;

class StoryController extends Controller
{
    
    public function indexAction()
    {
        $stories = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->findAllOrderByPriority();

        $storyRenderer = new StoryRenderer($this->container->getRouterService());

        return $this->render('MiamBundle:Story:index', array(
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

        return $this->render('MiamBundle:Story:show', array(
            'story' => $story
        ));
    }

    public function editAction($id)
    {
        $story = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->find($id);

        if (!$story) {
            throw new NotFoundHttpException("Story not found");
        }

        $projects = $this->getEntityManager()->getRepository('Bundle\MiamBundle\Entities\Project')->findAllIndexedById();

        $form = new StoryForm($story, array('projects' => $projects));
        
        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get($form->getName()));

            if($form->isValid()) {
                $form->updateObject();
                $this->getEntityManager()->persist($form->getObject());
                $this->getEntityManager()->flush();
                $this->getUser()->setFlash('story_update', array('story' => $form->getObject()->__toString()));
                return $this->redirect($this->generateUrl('backlog'));
            }
        }

        return $this->render('MiamBundle:Story:edit', array(
            'form' => $form,
            'story' => $story
        ));
    }

    public function newAction()
    {
        $projects = $this->getEntityManager()->getRepository('Bundle\MiamBundle\Entities\Project')->findAllIndexedById();

        $form = new StoryForm(new Story(), array('projects' => $projects));

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get('story'));

            if($form->isValid()) {
                $form->updateObject();
                $story = $form->getObject();
                $story->moveToTheEnd();
                
                $this->getEntityManager()->persist($story);
                $this->getEntityManager()->flush();
                
                $this->getUser()->setFlash('story_create', array('story' => $form->getObject()->__toString()));
                return $this->redirect($this->generateUrl('backlog'));
            }
            
        }

        return $this->render('MiamBundle:Story:new', array(
            'form' => $form
        ));
    }

    
}