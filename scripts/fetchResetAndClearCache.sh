git fetch origin;
git reset origin/master --hard;
php bin/console clear:cache --env=prod;
