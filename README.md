# Quick Setup

Copy all these commands and run from your source folder

```bash
# initialize environment variable
cp .env.example .env
# build docker images in parallel mode
docker-compose build --parallel
# start docker containers
docker-compose up -d
# access sv-php container
docker exec -it sv-php bash
# install all dependencies
COMPOSER_MEMORY_LIMIT=-1 composer install
yarn add
# generate app key
php artisan key:generate --force
# run migrations and seeder
php artisan migrate --seed
# restart supervisor (if needed)
supervisorctl restart laravel-websockets laravel-horizon
```

# Customize Setup

// TODO

# SSL Setup (Optional)

## Windows

-   Locate to `setup/nginx/certs/localhost.crt` using Windows Explorer
-   Double click and follow instructions on the screen to install certificate.

    Note: Make sure `Trusted Root Certification Authorities` is selected under `Certificate Store` section.

-   Restart browser.

## Linux (Ubuntu)

// TODO

# Useful Tips

> Re-build a service (i.e php service, do the same for others)

`docker-compose build php && docker-compose up -d`

> Re-build everything

`bash scripts/rebuild.sh`

These below commands need to run from `sv-php` container.

> Refresh testing database

`php artisan migrate:fresh --database=svdb_testing --seed`

> Add relations on tables

`php artisan schema:fix add-relations`

> Drop relations on tables

`php artisan schema:fix drop-relations`

> Enable hot-reload module

`yarn hot`

# Coding tips

## Laravel best practices

https://github.com/alexeymezenin/laravel-best-practices

## Proper ways to check empty array in PHP

https://www.drupal.org/project/features/issues/3074109
