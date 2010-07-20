INSTALL
=======

To configure your DB for your development and test environments, edit your `/miam/config/config_dev_local.yml` and `/miam/config/config_test_local.yml` to add your specific DB settings:

    imports:
      - { resource: config_dev.yml }

    doctrine.dbal:
      connections:
        default:
          driver:               PDOMySql
          dbname:               miam
          user:                 root
          password:             changeme
          host:                 localhost
          port:                 ~

Create your database and tables

    php miam/console-dev doctrine:database:drop
    php miam/console-dev doctrine:database:create
    php miam/console-dev doctrine:schema:create

    php miam/console-test doctrine:database:drop
    php miam/console-test doctrine:database:create
    php miam/console-test doctrine:schema:create

Generate the doctrine proxies

    php miam/console-dev doctrine:generate:proxies
    php miam/console-test doctrine:generate:proxies

Load fixtures

    php miam/console-dev doctrine:data:load
    php miam/console-test doctrine:data:load
  
Run unit tests

    phpunit src/Bundle/MiamBundle/Tests/AllTests.php

Run functional tests

    phpunit --bootstrap miam/tests/bootstrap/functional.php miam/tests/AllTests.php

To generate migrations from your current schema

    php miam/console-dev doctrine:migrations:diff --bundle=Bundle\\MiamBundle
    php miam/console-dev doctrine:migrations:migrate --bundle=Bundle\\MiamBundle
    php miam/console-dev doctrine:generate:proxies

About Miam
==========

Originally Miam is an internal project of our [Symfony2 web agency](http://www.knplabs.com), knpLabs.
We use it to manage our projects using the Scrum methodology.

Miam is also one of the first functional Symfony2+Doctrine2 projects ; we hope you can find some interesting stuff in the code.
Note however that for now Miam texts are only available in french.