<?php

require_once __DIR__.'/vendor/Symfony/src/Symfony/Framework/UniversalClassLoader.php';

$loader = new Symfony\Framework\UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'                   => __DIR__.'/vendor/Symfony/src',
    'Application'               => __DIR__,
    'Bundle'                    => __DIR__,
    'Doctrine\DBAL\Migrations'  => __DIR__.'/vendor/migrations/lib',
    'Doctrine\Common'           => __DIR__.'/vendor/doctrine/lib/vendor/doctrine-common/lib',
    'Doctrine\DBAL'             => __DIR__.'/vendor/doctrine/lib/vendor/doctrine-dbal/lib',
    'Doctrine'                  => __DIR__.'/vendor/doctrine/lib',
    'Zend'                      => __DIR__.'/vendor/zend/library',
));

$loader->register();
