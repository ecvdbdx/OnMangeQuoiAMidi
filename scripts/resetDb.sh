# Drops the database
php bin/console doctrine:database:drop --force; 
# Creates the database
php bin/console doctrine:database:create; 
# Updates the scema
php bin/console doctrine:schema:update --force; 
# Populate the data
php bin/console faker:populate;
# Create the super admin
php bin/console fos:user:create admin admin@admin.com admin --super-admin;
