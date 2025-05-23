FROM richarvey/nginx-php-fpm:3.1.6
RUN apk add --no-cache postgresql-dev && \
    docker-php-ext-install pdo_pgsql

COPY . /var/www/html
COPY conf/nginx/nginx-site.conf /etc/nginx/conf.d/default.conf
COPY php.ini /etc/php/conf.d/custom.ini

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

CMD ["/start.sh"]