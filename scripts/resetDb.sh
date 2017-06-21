#!/usr/bin/env bash

# Drops the database
php bin/console doctrine:database:drop --force; 
# Creates the database
php bin/console doctrine:database:create; 
# Updates the scema
php bin/console doctrine:schema:update --force; 
# Populate the data
php bin/console faker:populate;
# Create the super admin
php bin/console fos:user:create admin admin@test.com admin --super-admin;
# Create normal users
php bin/console fos:user:create Simon simon@test.com password;
php bin/console fos:user:create Bram bram@test.com password;
php bin/console fos:user:create Matthieu matthieu@test.com password;
php bin/console fos:user:create Florent florent@test.com password;
php bin/console fos:user:create Antoine antoine@test.com password;
php bin/console fos:user:create Guilhem guilhem@test.com password;
php bin/console fos:user:create Guillaume guillaume@test.com password;
php bin/console fos:user:create Clément clement@test.com password;
php bin/console fos:user:create Romain romain@test.com password;
