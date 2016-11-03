ECV PHP Project - Symfony3 (Docker)

# Includes
    
- Mysql 5.7.15
- Nginx 1.9.1
- PHP 7.0.7

# Installation
    
1. Clone this repository
1. Install and launch the containers
    ```
    docker-compose up
    ```
1. Point the container's IP address to symfony.dev
    * Example on mac OS `/etc/hosts` file: '127.0.0.1 symfony.dev' > /etc/hosts
    * On Windows, please note that the IP may be different (see if some IP is explicited during `docker-compose up`.
1. Install Symfony's dependencies using `composer` in the `symfony_php` container:
    ```
    docker exec -it symfony_php composer install
    ```
1. Enter these parameters when asked to configure the database. Leave the rest as default:
    ```
    parameters:
        database_host: db
        database_name: symfony
        database_user: root
        database_password: root
    ```
1. Install the front-end dependencies:
    ```
    npm install && npm build
    ```
1. Launch the browser on `symfony.dev/app_dev.php`
    
# Development

## Front-End
    
If you need to develop on the front-end:

1. Symlink the bundle assets folders in Symfony (optional)
    ```
    docker exec -it symfony_php bin/console assets:install --symlink
    ```
1. Start the watcher
    ```
    npm start
    ```
    
Now when you update the style.scss or app.js file, the bundled files are updated automatically by Gulp.


## Add remote PHP interpreter in PHPStorm (optional)

In PHPStorm go to Settings ->  Languages & Frameworks -> PHP

Add a new remote interpreter using the following SSH credentials
    . host: localhost
    . port: 2222
    . user: root
    . password: lbmonkey
