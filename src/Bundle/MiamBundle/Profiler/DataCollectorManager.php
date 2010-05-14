<?php

namespace Bundle\MiamBundle\Profiler;

use Symfony\Framework\ProfilerBundle\DataCollector\DataCollectorManager as Base;
use Symfony\Components\EventDispatcher\Event;
use Symfony\Components\HttpKernel\Response;

class DataCollectorManager extends Base
{
    public function handle(Event $event, Response $response)
    {
        if (!$event->getParameter('main_request')) {
            return $response;
        }

        $this->response = $response;

        foreach ($this->collectors as $name => $collector) {
            $collector->getData();
        }

        return $response;
    }
}
