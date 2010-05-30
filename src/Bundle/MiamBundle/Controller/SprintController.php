<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Bundle\MiamBundle\Entities\Sprint;
use Bundle\MiamBundle\Entities\Story;
use Bundle\MiamBundle\Renderer\SprintRenderer;
use Bundle\MiamBundle\Form\SprintForm;

class SprintController extends Controller
{
    
    public function newAction()
    {
        $form = new SprintForm(null);

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->get($form->getName()));

            if($form->isValid()) {
                $form->updateObject();
                $sprint = $form->getObject();
                                
                $this->getEntityManager()->persist($sprint);
                
                $this->getEntityManager()->flush();

                $this->getEntityManager()->getRepository('Bundle\MiamBundle\Entities\Sprint')->setCurrentSprint($sprint);
                
                $this->getEntityManager()->flush();
                
                $this->getUser()->setFlash('sprint_create', array('sprint' => $sprint->__toString()));

                return $this->redirect($this->generateUrl('backlog'));
            }
            
        }

        return $this->render('MiamBundle:Sprint:new', array(
            'form' => $form
        ));
    }
    
    public function currentAction()
    {
        $sprint = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Sprint')
        ->findCurrent();

        if(!$sprint)
        {
          throw new NotFoundHttpException('There is no current sprint!');
        }
        
        $projects = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Project')
        ->findForSprint($sprint);

        return $this->render('MiamBundle:Sprint:current', array(
          'projects' => $projects,
          'statuses' => Story::getSprintStatuses() 
        ));
    }
    
    public function scheduleAction()
    {
        $sprint = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Sprint')
        ->findCurrentWithStories();

        $stories = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->findBacklog();
        
        if(count($stories)) {
            $story = $stories[0];
        } else {
            $story = null;
        }

        return $this->render('MiamBundle:Sprint:schedule', array(
            'backlogStories' => $stories,
            'sprintStories' => $sprint->getStories(),
            'story' => $story,
            'sprint' => $sprint
        ));
    }

    public function unscheduleAction($id)
    {
        $story = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->find($id);

        if (!$story) {
            throw new NotFoundHttpException("Story '$id' not found");
        }
        
        $sprint = $story->getSprint();

        $sprint->removeStory($story);
        $story->setStatus(Story::STATUS_CREATED);
        $this->getEntityManager()->flush();
        
        return $this->redirect($this->generateUrl('sprint_schedule'));
    }
    
    public function addStoryAction()
    {
        $fakeForm = $this->getRequest()->get('story');
        $story = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->find($id = $fakeForm['id']);

        if (!$story) {
            throw new NotFoundHttpException("Story '$id' not found");
        }
        
        $sprint = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Sprint')
        ->findCurrent();

        $sprint->addStory($story);
        $story->setStatus($this->getRequest()->get('pending') ? Story::STATUS_PENDING : Story::STATUS_TODO);
        $this->getEntityManager()->flush();
        
        return $this->redirect($this->generateUrl('sprint_schedule'));
    }

}
