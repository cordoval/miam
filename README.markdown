INSTALL
-------

Run tests

    phpunit src/Bundle/MiamBundle/Tests/AllTests.php

Load fixtures

    php miam/console doctrine:data:load --fixtures=src/Bundle/MiamBundle/data/fixtures/doctrine/data.php