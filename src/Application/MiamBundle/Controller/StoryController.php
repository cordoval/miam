<?php

namespace Application\MiamBundle\Controller;

use Symfony\Bundle\DoctrineBundle\Controller\DoctrineController as Controller;
use Symfony\Components\HttpKernel\Exception\NotFoundHttpException;
use Application\MiamBundle\Entities\Story;
use Application\MiamBundle\Renderer\StoryRenderer;
use Application\MiamBundle\Form\StoryForm;
use Symfony\Components\EventDispatcher\Event;

class StoryController extends Controller
{

    public function indexAction()
    {
        $stories = $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\Story')
            ->findBacklog();

        return $this->render('MiamBundle:Story:index', array(
            'stories' => $stories,
        ));
    }

    public function moveAction()
    {
        $id = $this->getRequest()->get('story_id');

        $story = $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\Story')
            ->find($id);

        if (!$story) {
            throw new NotFoundHttpException("Story not found");
        }

        $status = $this->getRequest()->get('status');

        if($story->getStatus() != $status) {
            if(!Story::isValidStatus($status)) {
                throw new NotFoundHttpException("Status $status does not exist");
            }

            $story->setStatus($status);
            $this->getEntityManager()->flush();

            $this->notify(new Event($story, 'miam.story.status', array('status' => $story->getStatus())));
        }

        return $this->forward('MiamBundle:Sprint:ping', array('hash' => null));
    }


    public function reestimateAction()
    {
        $id = $this->getRequest()->get('story_id');

        $story = $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\Story')
            ->find($id);

        if (!$story)
        {
            throw new NotFoundHttpException("Story not found");
        }

        $points = intval($this->getRequest()->get('points'));

        if($story->getPoints() != $points) {
            $story->setPoints($points);
            $this->getEntityManager()->flush();
            $this->notify(new Event($story, 'miam.story.reestimate'));
        }

        return $this->createResponse('done');
    }

    public function sortAction()
    {
        $ids = $this->getRequest()->get('story');

        $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\Story')
            ->sort($ids);

        $this->getEntityManager()->flush();

        return $this->forward('MiamBundle:Sprint:ping', array('hash' => null));
    }

    public function showAction($id)
    {
        if(!$this->getRequest()->isXmlHttpRequest()) {
            if('test' !== $this->container['kernel.environment']) {
                throw new \Exception('The story show view can only be accessed from ajax');
            }
        }

        $story = $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\Story')
            ->find($id);

        if (!$story) {
            throw new NotFoundHttpException("Story not found");
        }

        $timeline = $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\TimelineEntry')
            ->findByStory($story);

        return $this->render('MiamBundle:Story:show', array(
            'story' => $story,
            'timeline' => $timeline,
            'emails' => $this->container->getParameter('miam.user.emails')
        ));
    }

    public function deleteAction($id)
    {
        $story = $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\Story')
            ->find($id);

        if (!$story) {
            throw new NotFoundHttpException("Story not found");
        }

        $story->markAsDeleted();
        $this->getEntityManager()->flush();
        $this->notify(new Event($story, 'miam.story.delete'));

        return $this->createResponse('ok');
    }

    public function editAction($id)
    {
        $story = $this->getEntityManager()
            ->getRepository('Application\MiamBundle\Entities\Story')
            ->findOneByIdWithProject($id);

        if (!$story) {
            throw new NotFoundHttpException("Story not found");
        }

        $projects = $this->getEntityManager()->getRepository('Application\MiamBundle\Entities\Project')->findAllIndexedById();
        $domains = Story::getDomains();

        $form = new StoryForm('story', $story, $this->container->getValidatorService(), array('projects' => $projects, 'domains' => $domains));

        if('POST' === $this->getRequest()->getMethod()) {
            $snapshot = $story->toArray();
            $form->bind($this->getRequest()->get('story'));

            if($form->isValid()) {
                $this->getEntityManager()->persist($story);
                $this->getEntityManager()->flush();

                if($story->getPoints() && !$snapshot['points']) {
                    $this->notify(new Event($story, 'miam.story.estimate'));
                }
                elseif($story->getPoints() != $snapshot['points']) {
                    $this->notify(new Event($story, 'miam.story.reestimate'));
                }

                if($story->getName() != $snapshot['name'] || $story->getBody() != $snapshot['body']) {
                    $this->notify(new Event($story, 'miam.story.edit'));
                }

                $timeline = $this->getEntityManager()->getRepository('Application\MiamBundle\Entities\TimelineEntry')->findByStory($story);
                return $this->render('MiamBundle:Story:show', array(
                    'story' => $story,
                    'timeline' => $timeline,
                    'emails' => $this->container->getParameter('miam.user.emails')
                ));
            }
        }

        return $this->render('MiamBundle:Story:edit', array(
            'form' => $form,
            'story' => $story
        ));
    }

    public function newAction()
    {
        $projects = $this->getEntityManager()->getRepository('Application\MiamBundle\Entities\Project')->findAllIndexedById();
        $domains = Story::getDomains();
        $story = new Story();

        $form = new StoryForm('story', $story, $this->container->getValidatorService(), array('projects' => $projects, 'domains' => $domains));

        if('POST' === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest()->get('story'));

            if($form->isValid()) {
                $story->moveToTheEnd();

                $this->getEntityManager()->persist($story);
                $this->getEntityManager()->flush();
                $this->container->getEventDispatcherService()->notify(new Event($story, 'miam.story.create'));

                return $this->createResponse('ok');
            }

        }

        return $this->render('MiamBundle:Story:new', array(
            'form' => $form
        ));
    }

    protected function notify(Event $event)
    {
        $this->container->getEventDispatcherService()->notify($event);
    }

}
