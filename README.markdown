INSTALL
-------

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

    php miam/console doctrine:database:create
    php miam/console doctrine:schema:create

    php miam/console-test doctrine:database:create
    php miam/console-test doctrine:schema:create

Load fixtures

    php miam/console doctrine:data:load --fixtures=src/Bundle/MiamBundle/Resources/data/fixtures/doctrine/data.php
    php miam/console-test doctrine:data:load --fixtures=src/Bundle/MiamBundle/Resources/data/fixtures/doctrine/data.php
  
Run unit tests

    phpunit src/Bundle/MiamBundle/Tests/AllTests.php

Run functional tests

    phpunit --bootstrap miam/tests/bootstrap/functional.php miam/tests/AllTests.php

