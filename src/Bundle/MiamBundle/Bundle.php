<?php

namespace Bundle\MiamBundle;

use Bundle\MiamBundle\DependencyInjection\MiamExtension;

use Symfony\Foundation\Bundle\Bundle as BaseBundle;

use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Components\DependencyInjection\BuilderConfiguration;

class Bundle extends BaseBundle
{
    public function buildContainer(ContainerInterface $container)
    {
        $configuration = new BuilderConfiguration();
        $loader = new XmlFileLoader(__DIR__.'/Resources/config');
        $configuration->merge($loader->load('auth.xml'));

        return $configuration;
    }
}