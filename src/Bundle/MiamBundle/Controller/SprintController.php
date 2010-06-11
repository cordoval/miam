<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Bundle\MiamBundle\Entities\Sprint;
use Bundle\MiamBundle\Entities\Story;
use Bundle\MiamBundle\Renderer\SprintRenderer;
use Bundle\MiamBundle\Form\SprintForm;
use Symfony\Components\EventDispatcher\Event;

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

                return $this->redirect($this->generateUrl('sprint_schedule'));
            }
            
        }

        return $this->render('MiamBundle:Sprint:new', array(
            'form' => $form
        ));
    }

    public function pingAction($hash)
    {
        $realHash = $this->getEntityManager()
            ->getRepository('Bundle\MiamBundle\Entities\Sprint')
            ->getCurrentHash();

        if($realHash != $hash) {
            $sprint = $this->getEntityManager()
                ->getRepository('Bundle\MiamBundle\Entities\Sprint')
                ->findCurrentWithStories();
            $projects = $this->getEntityManager()
                ->getRepository('Bundle\MiamBundle\Entities\Project')
                ->findForSprint($sprint);

            return $this->render('MiamBundle:Sprint:_current', array(
                'projects' => $projects,
                'sprint' => $sprint,
                'hash' => $realHash,
                'statuses' => Story::getSprintStatuses() 
            ));
        }

        return $this->createResponse('noop');
    }
    
    public function currentAction()
    {
        try
        {
            $sprint = $this->getEntityManager()
                ->getRepository('Bundle\MiamBundle\Entities\Sprint')
                ->findCurrentWithStories();
        }
        catch(\Doctrine\ORM\NoResultException $e)
        {
            return $this->redirect($this->generateUrl('sprint_new'));
        }

        $projects = $this->getEntityManager()
            ->getRepository('Bundle\MiamBundle\Entities\Project')
            ->findForSprint($sprint);

        $timeline = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\TimelineEntry')
        ->findLatest();

        $hash = $this->getEntityManager()
            ->getRepository('Bundle\MiamBundle\Entities\Sprint')
            ->getCurrentHash();

        return $this->render('MiamBundle:Sprint:current', array(
            'projects' => $projects,
            'sprint' => $sprint,
            'hash' => $hash,
            'statuses' => Story::getSprintStatuses(),
            'timeline' => $timeline,
            'emails' => $this->container->getParameter('miam.user.emails')
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
        $this->notify(new Event($story, 'miam.story.unschedule'));
        $this->getEntityManager()->flush();
        
        return $this->redirect($this->generateUrl('sprint_schedule'));
    }
    
    public function addStoryAction($id)
    {
        $story = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->find($id);

        if (!$story) {
            throw new NotFoundHttpException("Story '$id' not found");
        }
        
        $sprint = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Sprint')
        ->findCurrent();

        $sprint->addStory($story);
        $story->setStatus($this->getRequest()->get('pending') ? Story::STATUS_PENDING : Story::STATUS_TODO);
        $this->getEntityManager()->flush();

        $this->notify(new Event($story, 'miam.story.schedule'));
        
        return $this->redirect($this->generateUrl('sprint_schedule'));
    }

    protected function notify(Event $event)
    {
        $this->container->getEventDispatcherService()->notify($event);
    }

}
