#!/usr/bin/env bash

# Create a couple of super admins
php bin/console fos:user:create admin admin@test.com admin --super-admin;
php bin/console fos:user:create admin2 admin2@test.com admin --super-admin;
php bin/console fos:user:create admin3 admin3@test.com admin --super-admin;

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

# Populate the data
php bin/console faker:populate;
