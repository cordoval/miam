<?php

namespace Application\MiamBundle;

use Application\MiamBundle\DependencyInjection\MiamExtension;
use Symfony\Framework\Bundle\Bundle as BaseBundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;

class MiamBundle extends BaseBundle
{
    public function buildContainer(ParameterBagInterface $parameterBag)
    {
        Loader::registerExtension(new MiamExtension());
    }

    /**
     * Boots the Bundle.
     *
     * @param Symfony\Components\DependencyInjection\ContainerInterface $container A ContainerInterface instance
     */
    public function boot(ContainerInterface $container)
    {
        $container->getMiamObserverService()->connect();
    }

}
