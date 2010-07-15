<?php

namespace Application\MiamBundle\Controller;

use Symfony\Bundle\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Application\MiamBundle\Entities\Sprint;
use Application\MiamBundle\Entities\Story;
use Application\MiamBundle\Renderer\SprintRenderer;
use Application\MiamBundle\Form\SprintForm;
use Symfony\Components\EventDispatcher\Event;

class SprintController extends Controller
{
    
    public function newAction()
    {
        $sprint = new Sprint();
        $sprint->setStartsAt(new \DateTime());
        $sprint->setEndsAt(new \DateTime());
        $form = new SprintForm('sprint', $sprint, $this->container->getValidatorService());

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->get('sprint'));
            if($form->isValid()) {
                $this->getEntityManager()->persist($sprint);
                $this->getEntityManager()->flush();

                $this->getEntityManager()->getRepository('Application\MiamBundle\Entities\Sprint')->setCurrentSprint($sprint);
                
                $this->getEntityManager()->flush();
                
                $this->container->getSessionService()->setFlash('sprint_create', array('sprint' => $sprint->__toString()));

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
            ->getRepository('Application\MiamBundle\Entities\Sprint')
            ->getCurrentHash();

        if($realHash != $hash) {
            $sprint = $this->getEntityManager()
                ->getRepository('Application\MiamBundle\Entities\Sprint')
                ->findCurrentWithStories();
            $sections = $this->getEntityManager()
                ->getRepository('Application\MiamBundle\Entities\Story')
                ->findSprintStoriesIndexByProject($sprint);

            return $this->render('MiamBundle:Sprint:_current', array(
                'sections' => $sections,
                'sprint' => $sprint,
                'hash' => $realHash,
                'statuses' => Story::getSprintStatuses() 
            ));
        }

        return $this->createResponse('noop');
    }
    
    public function currentAction()
    {
        return $this->render('MiamBundle:Sprint:current', array(
            'emails' => $this->container->getParameter('miam.user.emails')
        ));
    }
    
    public function backlogAction()
    {
        $sections = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entities\Story')
        ->findBacklogIndexByProject();

        return $this->render('MiamBundle:Story:backlog', array('sections' => $sections));
    }

    public function unscheduleAction($id)
    {
        $story = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entities\Story')
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
    
    public function scheduleAction()
    {
        $id = $this->getRequest()->get('story_id');
        $story = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entities\Story')
        ->find($id);

        if (!$story) {
            throw new NotFoundHttpException("Story '$id' not found");
        }
        
        $sprint = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entities\Sprint')
        ->findCurrent();

        $sprint->addStory($story);
        $story->setStatus(Story::STATUS_TODO);
        $this->getEntityManager()->flush();

        $this->notify(new Event($story, 'miam.story.schedule'));
        
        return $this->forward('MiamBundle:Sprint:ping', array('hash' => null));
    }

    protected function notify(Event $event)
    {
        $this->container->getEventDispatcherService()->notify($event);
    }

}
