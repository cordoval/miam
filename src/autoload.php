<?php

require_once __DIR__.'/vendor/Symfony/src/Symfony/Foundation/UniversalClassLoader.php';

use Symfony\Foundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
  'Symfony'     => __DIR__.'/vendor/Symfony/src',
  'Application' => __DIR__,
  'Bundle'      => __DIR__,
  'Goutte'      => __DIR__.'/vendor/Goutte/src'
));
$loader->registerPrefixes(array(
  'Zend_'  => __DIR__.'/vendor/zend/library',
));
$loader->register();

set_include_path(__DIR__.'/vendor/zend/library'.PATH_SEPARATOR.get_include_path());

// Include symfony 1 stuff like sfForm
require_once __DIR__ . '/vendor/symfony1/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

// Include krumo debugger
require_once __DIR__ . '/vendor/krumo/class.krumo.php';