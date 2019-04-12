FROM php:7.3-fpm

MAINTAINER Sam Kroon

WORKDIR /var/www/html/

COPY ./api/composer.json /var/www/html
COPY ./api/composer.lock /var/www/html

# Install whatever softare you need using apt package manager
RUN apt-get update && apt-get install -y \
        && apt-get install -y wget \
        && apt-get install -y apt-utils

RUN apt-get update && apt-get install -y \
        && apt-get install -y zip \
        && apt-get install -y unzip

# Install whatever php extension you need
RUN docker-php-ext-install mbstring \
        && docker-php-ext-install opcache \
        && docker-php-ext-install pdo \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-install bcmath \
        && docker-php-ext-install sockets

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN composer install
