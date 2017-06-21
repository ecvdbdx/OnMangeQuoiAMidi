#!/usr/bin/env bash

git fetch origin;
git reset origin/master --hard;
composer install -o;
php bin/console cache:clear --env=prod;
./scripts/installDevelopment.sh
./scripts/phpmetrics.sh

