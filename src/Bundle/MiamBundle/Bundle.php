<?php

namespace Bundle\MiamBundle;

use Bundle\MiamBundle\DependencyInjection\MiamExtension;

use Symfony\Foundation\Bundle\Bundle as BaseBundle;
use Symfony\Components\DependencyInjection\ContainerInterface;
use Symfony\Components\DependencyInjection\Loader\Loader;

class Bundle extends BaseBundle
{
  public function buildContainer(ContainerInterface $container)
  {
    //Loader::registerExtension(new MiamExtension());
  }
}