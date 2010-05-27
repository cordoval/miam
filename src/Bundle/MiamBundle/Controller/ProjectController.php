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
        ->findWithBacklog($id);

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

        $form = $this->createForm($project);
        
        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->get($form->getName()));
            if($form->isValid()) {
                $this->getEntityManager()->persist($project);
                $this->getEntityManager()->flush();
                $this->getUser()->setFlash('project_update', array('project' => $project->__toString()));
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
      $form = $this->createForm($project);
      
      if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->get('project'));
            if($form->isValid()) {
                $this->getEntityManager()->persist($project);
                $this->getEntityManager()->flush();
                
                $this->getUser()->setFlash('project_create', array('project' => $project));
                return $this->redirect($this->generateUrl('projects'));
            }
        }

        return $this->render('MiamBundle:Project:new', array(
            'form' => $form
        ));
    }

    public function createForm(Project $project)
    {
        $options = array(
          'message_file' => realpath($this->container->getParameter('kernel.root_dir').'/..').'/src/vendor/Symfony/src/Symfony/Components/Validator/Resources/i18n/messages.en.xml',
          'validation_file' => realpath($this->container->getParameter('kernel.root_dir').'/..').'/src/vendor/Symfony/src/Symfony/Components/Form/Resources/config/validation.xml'
        );

        return new ProjectForm($project, $options);
    }

}
