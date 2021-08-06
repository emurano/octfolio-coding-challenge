# Octfolio Coding Challenge - Eric Murano

I have tried to make it as easy as possible to get the application up and running.

I didn't want to require the assessor to run any build steps when installing the application. So I have checked in the
composer `vendor/` directory. Normally I would not do this. Instead, I'd have the build and deploy
process include running `composer install`.

Also, the React application that serves as the UI for this application has been built
and checked in. Again, this is for ease of use. Normally I would include the downloading
of dependencies, compiling into ES5 and bundling as part of the deployment process.

I have included instructions on how to run various commands using Docker. This allows you to run
the correct versions of the tools without having to install anything other than Docker itself. 

NOTE: I accidentally checked in the config.ini file with the database connection details. As a result
I had to completely clobber the git log that I had. That's why this repository is very few commits.

## Installation - Apache

The following things are required for the application to run on Apache:

1. Create the `config.ini` file by copying `config.ini-example` and entering the database connection details
2. Copy the contents of the `src/` directory to `/var/www/html/` directory, or to the directory you have set up for the application
3. Enable mod_rewrite in apache
   ```bash
   a2enmod rewrite
   ```
4. Enable php_pdo and pdo_mysql
   ```bash
   apt-get install php7.4-mysql
   ```
   edit the `/etc/php/7.4/apache2/php.ini` file and uncomment the appropriate extension
   ```ini
   extension=pdo_mysql.so
   ```
5. Point document root to the `/var/www/html/public` directory.

## Installation - Docker

If you have Docker installed you can run the application using docker-compose.

From the root directory of the project, run:

```bash
docker-compose --file resources/docker-compose.yml up
```

Then access http://localhost/


## Composer

While I am not using any libraries, I did want to keep my own code in classes and use class auto-loading instead of including class files. Instead of writing my own class auto-loading code, I installed composer and used it's PSR-4  auto-loading feature.

## Running Composer through Docker

If you need to run any composer commands, use this docker run command to do it without having to install composer natively.

Run this command in the root directory.

```bash
docker run --rm --interactive --tty --volume $PWD:/app composer YOUR_COMMAND_HERE
```

Some composer commands:
```bash
docker run --rm --interactive --tty --volume $PWD:/app composer install
docker run --rm --interactive --tty --volume $PWD:/app composer require psr/http-message
```

## Building the web app

The web application has been built and its build has been checked in, for ease of use while assessing the submission.

If you wish to rebuild the web app, install node and yarn and run the following:

```bash
yarn run webpack
```

You can run the command through Docker to avoid having to install node or yarn:

```bash
 docker run --rm --interactive --tty --volume $PWD:/usr/src/app -w /usr/src/app node:15 yarn run webpack
```
