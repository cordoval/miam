<?php

namespace Application\MiamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Application\MiamBundle\Entity\Project;
use Application\MiamBundle\Renderer\ProjectRenderer;
use Application\MiamBundle\Form\ProjectForm;
use Symfony\Components\EventDispatcher\Event;

class ProjectController extends Controller
{

    public function indexAction()
    {
        $projects = $this->getEntityManager()->getRepository('Application\MiamBundle\Entity\Project')->findAllOrderByCreatedAt();

        return $this->render('MiamBundle:Project:index', array(
            'projects' => $projects,
        ));
    }

    public function showAction($id)
    {
        $project = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entity\Project')
        ->findWithBacklog($id);

        if (!$project) {
            throw new NotFoundHttpException("Project not found");
        }

        return $this->render('MiamBundle:Project:show', array(
            'project' => $project
        ));
    }

    public function deleteAction($id)
    {
        $project = $this->getEntityManager()
        ->getRepository('Application\MiamBundle\Entity\Project')
        ->find($id);

        if (!$project) {
            throw new NotFoundHttpException("Project not found");
        }

        $this->getEntityManager()->remove($project);
        $this->getEntityManager()->flush();

        return $this->redirect($this->generateUrl('projects'));
    }


    public function editAction($id)
    {
        $project = $this->getEntityManager()->getRepository('Application\MiamBundle\Entity\Project')->find($id);

        if (!$project) {
            throw new NotFoundHttpException("Project not found");
        }

        $form = new ProjectForm('project', $project, $this->container->getValidatorService());
        
        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->get($form->getName()));
            if($form->isValid()) {
                $this->getEntityManager()->persist($project);
                $this->getEntityManager()->flush();
                $this->container->getSessionService()->setFlash('project_update', array('project' => $project->__toString()));
                return $this->redirect($this->generateUrl('projects'));
            }
        }

        return $this->render('MiamBundle:Project:edit', array(
            'form' => $form,
            'project' => $project
        ));
    }

    public function newAction()
    {
      $project = new Project();
      $form = new ProjectForm('project', $project, $this->container->getValidatorService());
      
      if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->get('project'));
            if($form->isValid()) {
                $this->getEntityManager()->persist($project);
                $this->getEntityManager()->flush();
                
                $this->container->getEventDispatcherService()->notify(new Event($project, 'miam.project.create'));

                $this->container->getSessionService()->setFlash('project_create', array('project' => $project));
                return $this->redirect($this->generateUrl('projects'));
            }
        }

        return $this->render('MiamBundle:Project:new', array(
            'form' => $form
        ));
    }

    public function sortAction()
    {
        $ids = $this->getRequest()->get('project');

        $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entity\Project')
            ->sort($ids);

        $this->getEntityManager()->flush();

        return $this->forward('MiamBundle:Sprint:ping', array('hash' => null));
    }

    protected function getEntityManager()
    {
        return $this->container->getDoctrine_ORM_EntityManagerService();
    }
}
