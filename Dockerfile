FROM composer:2.8.10 AS composer
FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y libssl-dev pkg-config unzip && \
    if ! php -m | grep -q mongodb; then pecl install mongodb; fi && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli pdo pdo_mysql


COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY config/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && \
    a2ensite 000-default.conf && \
    chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html/public

EXPOSE 80

