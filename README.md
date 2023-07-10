# Simple Pass

Introducing our Password Management Project: a simple and secure solution for managing passwords. Say goodbye to the hassle of remembering multiple passwords as our user-friendly interface and robust encryption techniques ensure easy access and protection of your sensitive information. Simplify your digital life and take control of your online security with our password management project.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
Docker
Git
```

### Installing

A step by step series of examples that tell you how to get a development env running

To install Docker, please follow the instructions found here:
https://docs.docker.com/desktop/

Install Git from the following link: https://git-scm.com/downloads

After both Docker and Git have been installed, clone the repository.

```
git clone https://github.com/Dubbie/simple-pass.git
```

Copy the `.env.example` file and rename it to `.env`

```
cp .env.example .env
```

Install dependencies using Docker

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Run the container by using the following command

```
./vendor/bin/sail up -d
```

After this, you will have to run a few commands which will accomplish the following:

-   Generate an application encryption key
-   Run the required migrations to set up the database
-   Install required Node modules to develop with

```
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
```

Setup is now complete, you can run the following code to start Vite to develop something awesome!

```
./vendor/bin/sail npm run dev
```

#### Optional step

To make running commands smoother you can save the following alias:

```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

This setting depends on your OS of choice, so it may vary. After this, you can use the above commands using only `sail` you don't have to write the full path of `./vendor/bin/sail`.

## Deployment

To deploy this project to a production environment, you can follow the steps below. Please note that these steps may vary depending on your hosting provider.

Install the composer dependencies by running the following command.

```
composer install --no-dev --optimize-autoloader
```

Build the assets required.

```
npm install
```

Move the files to the host, be careful not to put everything into the `public_html` folder as this is a security breach, everyone can access your data.

Run the following command to create an encryption key.

```
cp .env.example .env
php artisan key:generate
```

Make sure to fill out the database settings, mail settings and base admin user settings in the `.env` file.

Run the migrations to prepare the database.

```
php artisan migrate --force
```

The application should now be up and running in your production enviroment.

## Built With

-   [Laravel](https://laravel.com/docs/) - The web framework used
-   [Vue](https://vuejs.org/guide/introduction.html) - Frontend JavaScript framework
-   [Inertia.js](https://inertiajs.com/) - Glue that connects Laravel with Vue

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).

## Authors

-   **Mihó Dániel** - [Dubbie](https://github.com/Dubbie)
