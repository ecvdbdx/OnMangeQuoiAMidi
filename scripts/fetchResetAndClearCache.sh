#!/usr/bin/env bash

git fetch origin;
git reset origin/master --hard;
composer install -o;
php bin/console cache:clear --env=prod;
latest_commit=$(git log -1 --format=%cd)
sed -i "" "s/\${latest_commit}/${latest_commit}/" app/Resources/views/base.html.twig
./scripts/installDevelopment.sh
./scripts/phpmetrics.sh

