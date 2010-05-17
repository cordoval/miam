<?php

namespace Bundle\MiamBundle\Controller;

use Symfony\Framework\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Bundle\MiamBundle\Entities\Project;
use Bundle\MiamBundle\Renderer\ProjectRenderer;
use Bundle\MiamBundle\Form\ProjectForm;

class ProjectController extends Controller
{

    public function indexAction()
    {
        $projects = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Project')
        ->findAllOrderByInterest();

        return $this->render('MiamBundle:Project:index', array(
            'projects' => $projects,
        ));
    }

    public function showAction($id)
    {
        $project = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Project')
        ->find($id);

        if (!$project) {
            throw new NotFoundHttpException("Project not found");
        }

        return $this->render('MiamBundle:Project:show', array(
            'project' => $project
        ));
    }

    public function editAction($id)
    {
        $project = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Project')
        ->find($id);

        if (!$project) {
            throw new NotFoundHttpException("Project not found");
        }

        $form = new ProjectForm($project);
        
        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get($form->getName()));

            if($form->isValid()) {
                $form->updateObject();
                $this->getEntityManager()->persist($form->getObject());
                $this->getEntityManager()->flush();
                $this->getUser()->setFlash('project_update', array('project' => $form->getObject()->__toString()));
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
        $form = new ProjectForm(new Project());

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get('project'));

            if($form->isValid()) {
                $form->updateObject();
                $this->getEntityManager()->persist($form->getObject());
                $this->getEntityManager()->flush();
                
                $this->getUser()->setFlash('project_create', array('project' => $form->getObject()->__toString()));
                return $this->redirect($this->generateUrl('projects'));
            }
            
        }

        return $this->render('MiamBundle:Project:new', array(
            'form' => $form
        ));
    }

}