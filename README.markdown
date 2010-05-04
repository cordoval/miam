INSTALL
-------

To configure your DB for your development environment, edit `/miam/config/config_dev_local.yml`

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

Run tests

    phpunit src/Bundle/MiamBundle/Tests/AllTests.php

Create tables

    php miam/console doctrine:schema:create

Load fixtures

    php miam/console doctrine:data:load --fixtures=src/Bundle/MiamBundle/data/fixtures/doctrine/data.php