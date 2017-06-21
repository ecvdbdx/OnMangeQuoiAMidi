# On Mange Quoi À Midi

Un projet en Symfony 3.

<a href="https://travis-ci.org/ecvdbdx1617/OnMangeQuoiAMidi/" title="Lien vers Travis"><img src="https://travis-ci.org/ecvdbdx1617/OnMangeQuoiAMidi.svg?branch=master" alt="build"></a>

## Prerequisites
    
- Mysql 5.7.15
- Nginx 1.9.1
- PHP 7.0.7
- Node 7+

## Installation
    
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
    
## Development

### Populating & resetting the database

#### Reset database

`docker exec -it symfony_php php bin/console doctrine:schema:drop --force`
`docker exec -it symfony_php php bin/console doctrine:schema:create`

#### Generate fixtures

Fake datas (fixtures) generated with the [Bazinga Faker Bundle](https://github.com/willdurand/BazingaFakerBundle/)

In order to add fixtures into the database to work with, follow these steps :

1 - make sure to have the last database schema :

`docker exec -it symfony_php php bin/console doctrine:schema:update --force`

2 - Execute the Bazinga Faker command to populate the database

`docker exec -it symfony_php php bin/console faker:populate`

> NB : Entries are INSERTED into database, your previous entries won't be erased

#### Add fixtures

Fixtures are declared in `app/config/config_dev.yml` under the bazinga_faker entry.
We first declare the ORM used and the location (locale) to get the datas in the correct language.
The fixtures are then inserted based on entities.

Example for place entity :

``` yml
AppBundle\Entity\Place:
            number: 50 # Choose the number of entries to generate
            custom_formatters:
                name: { method: company }
                description: { method: realText }
                ... # Make sure to add one new based on your entity entry
``` 

[See all available methods](https://github.com/fzaninotto/Faker#formatters)

### Front-End
    
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


### Add remote PHP interpreter in PHPStorm (optional)

In PHPStorm go to Settings ->  Languages & Frameworks -> PHP

Add a new remote interpreter using the following SSH credentials
    . host: localhost
    . port: 2222
    . user: root
    . password: lbmonkey

### Generate PHPMetrics report

```
./scripts/phpmetrics;
```

The report will be accessible at : `/phpmetrics/index.html`
