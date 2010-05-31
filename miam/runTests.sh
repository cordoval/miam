#!/bin/sh
export DIR=`dirname $0`/..
phpunit --bootstrap $DIR/miam/tests/bootstrap/functional.php --log-junit $DIR/miam/logs/$1.xml $DIR/miam/tests/AllTests.php