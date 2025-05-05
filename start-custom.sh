#!/bin/bash
# Kiểm tra PHP-FPM
echo "Starting PHP-FPM..."
php-fpm -t || { echo "PHP-FPM configuration test failed"; exit 1; }
# Khởi động PHP-FPM
php-fpm -D
# Kiểm tra Nginx
echo "Starting Nginx..."
nginx -t || { echo "Nginx configuration test failed"; exit 1; }
# Khởi động Nginx
nginx -g "daemon off;"