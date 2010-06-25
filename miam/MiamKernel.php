<?php

require_once __DIR__.'/../src/autoload.php';

use Symfony\Foundation\Kernel;
use Symfony\Components\DependencyInjection\Loader\YamlFileLoader as ContainerLoader;
use Symfony\Components\Routing\Loader\YamlFileLoader as RoutingLoader;

class MiamKernel extends Kernel
{
  
  public function registerRootDir()
  {
    return __DIR__;
  }

  public function registerBundles()
  {
    $bundles = array(
      new Symfony\Foundation\Bundle\KernelBundle(),
      new Symfony\Framework\DoctrineBundle\DoctrineBundle(),
      new Symfony\Framework\DoctrineMigrationsBundle\DoctrineMigrationsBundle(),
      new Symfony\Framework\FoundationBundle\FoundationBundle(),
      new Symfony\Framework\ZendBundle\ZendBundle(),
      new Bundle\MarkdownBundle\MarkdownBundle(),
      new Bundle\DoctrineUserBundle\DoctrineUserBundle(),
      new Bundle\MiamBundle\MiamBundle()
    );

    return $bundles;
  }

  public function registerBundleDirs()
  {
    return array(
      'Bundle'             => __DIR__.'/../src/Bundle',
      'Symfony\\Framework' => __DIR__.'/../src/vendor/Symfony/src/Symfony/Framework',
    );
  }

  /**
   * Returns the config_{environment}_local.yml file or 
   * the default config_{environment}.yml if it does not exist.
   * Useful to override development password.
   *
   * @param string Environment
   * @return The configuration file path
   */
  protected function getLocalConfigurationFile($environment)
  {
    $basePath = __DIR__.'/config/config_';
    $file = $basePath.$environment.'_local.yml';
    
    if(\file_exists($file))
    {
      return $file;
    }
    
    return $basePath.$environment.'.yml';
  }
  
  public function registerContainerConfiguration()
  {
    $loader = new ContainerLoader($this->getBundleDirs());

    $configuration = $loader->load($this->getLocalConfigurationFile($this->getEnvironment()));
    $configuration->merge($loader->load(__DIR__.'/config/dic_'.$this->getEnvironment().'.yml'));

    return $configuration;
  }

  public function registerRoutes()
  {
    $loader = new RoutingLoader($this->getBundleDirs());

    return $loader->load(__DIR__.'/config/routing.yml');
  }
}
