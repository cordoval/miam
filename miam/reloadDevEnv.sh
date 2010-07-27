#!/bin/sh
# Usage: ./miam/reloadDevEnv.sh
php miam/console-dev doctrine:database:drop &&
php miam/console-dev doctrine:database:create &&
php miam/console-dev doctrine:schema:create &&
php miam/console-dev doctrine:generate:proxies &&
php miam/console-dev doctrine:data:load &&
echo "You're good to go!"
