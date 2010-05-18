#!/bin/sh
# Usage: ./miam/reloadTestEnv.sh
php miam/console-test doctrine:database:drop &&
php miam/console-test doctrine:database:create &&
php miam/console-test doctrine:schema:create &&
php miam/console-test doctrine:generate:proxies &&
php miam/console-test doctrine:data:load &&
echo "You're good to go!"
