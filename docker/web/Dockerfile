FROM php:8.0-apache AS base

#tools installieren
RUN apt-get update && apt-get install -y \
    vim \
    iputils-ping \
    tcptraceroute \
    unzip \

#mysql installieren
RUN docker-php-ext-install pdo pdo_mysql

#php.ini-production auf php.ini umbenennen
RUN mv "/usr/local/etc/php/php.ini-production" "/usr/local/etc/php/php.ini"

#composer installieren
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

#document root ändern auf den public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

#url rewrite erlauben (dass alles an index.php gesendet wird)
#dass .htaccess läuft
RUN a2enmod rewrite