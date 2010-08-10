<?php

namespace Application\MiamBundle;

use Application\MiamBundle\DependencyInjection\MiamExtension;
use Symfony\Framework\Bundle\Bundle as BaseBundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Components\DependencyInjection\ContainerBuilder;
use Symfony\Components\HttpKernel\HttpKernelInterface; 
use Symfony\Components\EventDispatcher\Event;

class MiamBundle extends BaseBundle
{
    public function buildContainer(ParameterBagInterface $parameterBag)
    {
        ContainerBuilder::registerExtension(new MiamExtension());
    }

    /**
     * Boots the Bundle.
     *
     * @param Symfony\Components\DependencyInjection\ContainerInterface $container A ContainerInterface instance
     */
    public function boot()
    {
        parent::boot();
        $container = $this->container;
        $container->getEventDispatcherService()->connect('core.request', function(Event $event) use ($container) {
            if(HttpKernelInterface::MASTER_REQUEST === $event['request_type']) {
                $session = $container->getSessionService();
                $session->start();
                if(!$session->getAttribute('identity') && $event['request']->attributes->get('_controller') !== 'MiamBundle:Miam:fastLogin') {
                    $event['request']->attributes->set('_controller', 'MiamBundle:Miam:fastLogin');
                    $event['request']->attributes->set('username', '');
                }
            }
        });
        $container->getMiamObserverService()->connect();
    }

}
