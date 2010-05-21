<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Bundle\MiamBundle\Entities\Sprint;
use Bundle\MiamBundle\Renderer\SprintRenderer;
use Bundle\MiamBundle\Form\SprintForm;

class SprintController extends Controller
{
    
    public function newAction()
    {
        $form = new SprintForm(null);

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get($form->getName()));

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
        return $this->render('MiamBundle:Sprint:current');
    }
    
    public function scheduleAction()
    {
        $sprint = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Sprint')
        ->findCurrent();

        $stories = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->findAllOrderByPriority();
        
        $story = $stories[0];

        return $this->render('MiamBundle:Sprint:schedule', array(
            'backlogStories' => $stories,
            'sprintStories' => $sprint->getStories(),
            'story' => $story,
        ));
    }
    
    public function addToSprintAction()
    {
        # code...
    }

}
