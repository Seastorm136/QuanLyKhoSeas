#!/usr/bin/env bash
echo "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html
echo "Caching config..."
php artisan config:cache
echo "Listing routes..."
php artisan route:list > /var/www/html/storage/logs/routes.log
echo "Running migrations..."
php artisan migrate --force