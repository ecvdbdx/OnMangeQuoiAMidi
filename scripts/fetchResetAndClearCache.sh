#!/usr/bin/env bash

git fetch origin;
git reset origin/master --hard;
composer install -o;
npm i;
npm run build;
php bin/console cache:clear --env=prod;
./scripts/resetDb.sh
./scripts/phpmetrics.sh

