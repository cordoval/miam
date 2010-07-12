<?php

namespace Bundle\MiamBundle\Event;

use Doctrine\ORM\EntityManager;
use Symfony\Foundation\EventDispatcher;
use Symfony\Components\EventDispatcher\Event;
use Symfony\Framework\FoundationBundle\User as SymfonyUser;
use Bundle\MiamBundle\Entities\TimelineEntry;
use Bundle\MiamBundle\Entities\Story;

class Observer
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var SymfonyUser
     */
    protected $user;

    public function __construct(EntityManager $em, EventDispatcher $dispatcher, SymfonyUser $user)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->user = $user;

        $this->connect();
    }

    protected function connect()
    {
        $observer = $this;
        
        $this->dispatcher->connect('miam.story.reestimate', function(Event $event) use ($observer) {
            $observer->addStoryEntry($event->getSubject(), TimelineEntry::ACTION_REESTIMATE);
        });

        $this->dispatcher->connect('miam.story.estimate', function(Event $event) use ($observer) {
            $observer->addStoryEntry($event->getSubject(), TimelineEntry::ACTION_ESTIMATE);
        });

        $this->dispatcher->connect('miam.story.edit', function(Event $event) use ($observer) {
            $observer->addStoryEntry($event->getSubject(), TimelineEntry::ACTION_EDIT);
        });

        $this->dispatcher->connect('miam.story.create', function(Event $event) use ($observer) {
            $observer->addStoryEntry($event->getSubject(), TimelineEntry::ACTION_CREATE);
        });

        $this->dispatcher->connect('miam.story.delete', function(Event $event) use ($observer) {
            $observer->addStoryEntry($event->getSubject(), TimelineEntry::ACTION_DELETE);
        });

        $this->dispatcher->connect('miam.story.schedule', function(Event $event) use ($observer) {
            $observer->addStoryEntry($event->getSubject(), TimelineEntry::ACTION_SCHEDULE);
        });

        $this->dispatcher->connect('miam.story.unschedule', function(Event $event) use ($observer) {
            $observer->addStoryEntry($event->getSubject(), TimelineEntry::ACTION_UNSCHEDULE);
        });

        $this->dispatcher->connect('miam.story.status', function(Event $event) use ($observer) {
            $action = TimelineEntry::getActionForStoryStatus($event['status']);
            $observer->addStoryEntry($event->getSubject(), $action);
        });
    }

    public function addStoryEntry(Story $story, $action)
    {
        $identity = $this->user->getAttribute('identity');

        if(!$identity) {
            throw new \Exception('No user logged in');
        }
        $doctrineUser = $this->em->getRepository('Bundle\DoctrineUserBundle\Entities\User')->find($identity->getId());

        $tentry = new TimelineEntry();
        $tentry->setUser($doctrineUser);
        $tentry->setStory($story);
        $tentry->setPoints($story->getPoints());
        $tentry->setAction($action);

        $this->em->persist($tentry);
        $this->em->flush();
    }

}
