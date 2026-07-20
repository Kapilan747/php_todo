#!/bin/bash
set -e

echo "Starting Laravel container..."

php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "Running database migrations..."
php artisan migrate --force

php-fpm -D

nginx -g "daemon off;"