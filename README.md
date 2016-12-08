ECV PHP Project - Symfony3 (Docker)

## Includes
    
- Mysql 5.7.15
- Nginx 1.9.1
- PHP 7.0.7

## Dependencies

- NPM

## Installation

### Back-end
    
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
    7 - Launch the brower on symfony.dev/app_dev.php
    
### Front-end
    
    1 - Install all the node dependences
        - 'npm install'
    2 - Compile Front-end assets
        - 'npm run build:dev' on local machine or 'npm run build:prod' in production
    3 - Symlink the assets in symfony
        - 'docker exec -it symfony_php bin/console assets:install --symlink'
    4 - When developing, automatically compile CSS and JS after file modification
        - 'npm run watch:css' for CSS
        - 'npm run watch:js' for JS
    
        
#### Other available NPM scripts
    
- **`npm run build:js:dev`** Build JS file with sourcemaps & run linter
- **`npm run build:js:prod`** Build JS filed without sourcemaps
- **`npm run watch:js`** Execute `npm run build:js:dev` when a JS file changes
- **`npm run uglify:js`** Optimize generated JS file
- **`npm run lint:js`** Run ESLint on all unbundled JS files
- **`npm run build:css:dev`** Build CSS file with sourcemaps and not optimized
- **`npm run build:css:prod`** Build CSS file without sourcemaps and optimized
- **`npm run watch:css`** Execute `npm run build:css:dev` when a SCSS file changes
- **`npm run build:dev`** Execute `npm run build:js:dev` and `npm run build:css:dev`
- **`npm run build:prod`** Execute `npm run build:js:prod` and `npm run build:css:prod`
        


## Add remote PHP interpreter in PHPStorm (optional)

    In PHPStorm go to Settings ->  Languages & Frameworks -> PHP
    
    Add a new remote interpreter using the following SSH credentials
        - host: localhost
        - port: 2222
        - user: root
        - password: lbmonkey
