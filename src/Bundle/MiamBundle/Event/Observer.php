<?php

namespace Bundle\MiamBundle\Event;

use Doctrine\ORM\EntityManager;
use Symfony\Foundation\EventDispatcher;

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

    public function __construct(EntityManager $em, EventDispatcher $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;

        $this->connect();
    }

    protected function connect()
    {
    }

}
