#!/bin/sh

chmod 777 -R storage/
chmod 777 -R bootstrap/cache/

composer install

php artisan migrate
php artisan key:generate

php-fpm