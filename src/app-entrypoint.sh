#!/bin/sh

chmod 777 -R storage/
chmod 777 -R bootstrap/cache/

composer install

php artisan key:generate
php artisan migrate

php-fpm