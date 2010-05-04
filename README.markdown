INSTALL
-------

Run tests

    phpunit src/Bundle/MiamBundle/Tests/AllTests.php

Create tables

    php miam/console doctrine:schema:create

Load fixtures

    php miam/console doctrine:data:load --fixtures=src/Bundle/MiamBundle/data/fixtures/doctrine/data.php