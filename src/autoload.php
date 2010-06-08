<?php

require_once __DIR__.'/vendor/Symfony/src/Symfony/Foundation/UniversalClassLoader.php';

use Symfony\Foundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
  'Symfony'     => __DIR__.'/vendor/Symfony/src',
  'Bundle'      => __DIR__,
  'Doctrine\DBAL\Migrations' => __DIR__.'/vendor/migrations/lib',
  'Doctrine\DBAL'    => __DIR__.'/vendor/doctrine/lib/vendor/doctrine-dbal/lib',
  'Doctrine\Common'    => __DIR__.'/vendor/doctrine/lib/vendor/doctrine-common/lib',
  'Doctrine'    => __DIR__.'/vendor/doctrine/lib',
  'Zend'    => __DIR__.'/vendor/zend/library',
));
$loader->register();

// Include symfony 1 stuff like sfForm
require_once __DIR__ . '/vendor/symfony1/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();
