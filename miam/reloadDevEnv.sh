#!/bin/sh
# Usage: ./miam/reloadDevEnv.sh
php miam/console doctrine:database:drop &&
php miam/console doctrine:database:create &&
php miam/console doctrine:schema:create &&
php miam/console doctrine:generate:proxies &&
php miam/console doctrine:data:load &&
echo "You're good to go!"
