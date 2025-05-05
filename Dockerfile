FROM richarvey/nginx-php-fpm:3.1.6
RUN apk add --no-cache postgresql-client
RUN sed -i 's/listen = \/var\/run\/php-fpm.sock/listen = 127.0.0.1:9000/' /etc/php/php-fpm.d/www.conf
COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

COPY start-custom.sh /start-custom.sh
RUN chmod +x /start-custom.sh
CMD ["/start.sh"]