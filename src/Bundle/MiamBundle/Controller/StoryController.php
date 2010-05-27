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
        ->findBacklog();

        return $this->render('MiamBundle:Story:index', array(
            'stories' => $stories,
        ));
    }

    public function moveAction()
    {
        $id = $this->getRequest()->request->get('story_id');

        $story = $this->getEntityManager()
        ->getRepository('Bundle\MiamBundle\Entities\Story')
        ->find($id);

        if (!$story)
        {
            throw new NotFoundHttpException("Story not found");
        }

        $status = $this->getRequest()->request->get('status');

        if(!Story::isValidStatus($status))
        {
          throw new NotFoundHttpException("Status $status does not exist");
        }

        $story->setStatus($status);
        $this->getEntityManager()->flush();

        return $this->createResponse('done');
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
        ->findOneByIdWithProject($id);

        if (!$story) {
            throw new NotFoundHttpException("Story not found");
        }

        $projects = $this->getEntityManager()->getRepository('Bundle\MiamBundle\Entities\Project')->findAllIndexedById();

        $form = $this->createForm($story, $projects);
        
        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get($form->getName()));

            if($form->isValid()) {
                $this->getEntityManager()->persist($story);
                $this->getEntityManager()->flush();
                $this->getUser()->setFlash('story_update', array('story' => $story));
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

        $story = new Story();
        $form = $this->createForm($story, $projects);

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->request->get('story'));

            if($form->isValid()) {
                $story->moveToTheEnd();
                
                $this->getEntityManager()->persist($story);
                $this->getEntityManager()->flush();
                
                $this->getUser()->setFlash('story_create', array('story' => $story));
                return $this->redirect($this->generateUrl('backlog'));
            }
            
        }

        return $this->render('MiamBundle:Story:new', array(
            'form' => $form
        ));
    }

    public function createForm(Story $story, array $projects)
    {
        $options = array(
          'message_file' => realpath($this->container->getParameter('kernel.root_dir').'/..').'/src/vendor/Symfony/src/Symfony/Components/Validator/Resources/i18n/messages.en.xml',
          'validation_file' => realpath($this->container->getParameter('kernel.root_dir').'/..').'/src/vendor/Symfony/src/Symfony/Components/Form/Resources/config/validation.xml'
        );

        return new StoryForm($story, array_merge($options, array('projects' => $projects)));
    }

    
}
