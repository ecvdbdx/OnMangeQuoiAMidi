ECV PHP Project - Symfony3 (Docker)

### Includes
    
- Mysql 5.7.15
- Nginx 1.9.1
- PHP 7.0.7

### Installation
    
    Hi ! 
    How are you today guys ! Me i'm good. Last night, I ate pastas and yeah. Well. 
    SO ! 
    EVERYBODY CALM THE FUCK DOWWWWN. 
    In order to install the project, you need a fewwww dependicies.
    Alright. 
    SO. 
    You need to install first : 
    - npm
    - bower
    
    1 - Clone this repository
    2 - Point the container's IP address to symfony.dev
        - ex: '127.0.0.1 symfony.dev' > /etc/hosts
    3 - Install and launch the containers
        - 'docker-compose up'
    4 - Install Symfony's dependencies using composer
        - 'docker exec -it symfony_php composer install'
    5 - Enter these parameters when asked to configure the database. Leave the rest as default
        - host : db
        - database name : symfony
        - user : root
        - password : root
    6 - Restart the docker containers
    7 - Install foundation
        - 'bower install'
    8 - Launch the brower on symfony.dev/app_dev.php


### Add remote PHP interpreter in PHPStorm (optional)

    In PHPStorm go to Settings ->  Languages & Frameworks -> PHP
    
    Add a new remote interpreter using the following SSH credentials
        - host: localhost
        - port: 2222
        - user: root
        - password: lbmonkey
