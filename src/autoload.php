<?php

require_once __DIR__.'/vendor/Symfony/src/Symfony/Foundation/UniversalClassLoader.php';

use Symfony\Foundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
  'Symfony'     => __DIR__.'/vendor/Symfony/src',
  'Bundle'      => __DIR__,
  'Doctrine\DBAL\Migrations' => __DIR__.'/vendor/migrations/lib',
  'Doctrine'    => __DIR__.'/vendor/doctrine/lib'
));
$loader->registerPrefixes(array(
  'Zend_'  => __DIR__.'/vendor/zend/library',
  'Twig_'  => __DIR__.'/vendor/Twig/lib',
));
$loader->register();

set_include_path(__DIR__.'/vendor/zend/library'.PATH_SEPARATOR.get_include_path());

// Include symfony 1 stuff like sfForm
require_once __DIR__ . '/vendor/symfony1/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();