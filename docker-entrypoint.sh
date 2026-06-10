#!/bin/sh
set -e

composer install

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate

php artisan migrate

php artisan db:seed

php artisan storage:link