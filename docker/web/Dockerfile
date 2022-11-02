FROM php:8.0-apache AS base
RUN apt-get update && apt-get install -y \
    vim \
    iputils-ping \
    tcptraceroute \
    unzip \

RUN docker-php-ext-install pdo pdo_mysql
RUN mv "/usr/local/etc/php/php.ini-production" "/usr/local/etc/php/php.ini"
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite