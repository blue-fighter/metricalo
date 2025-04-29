FROM phpdockerio/php:8.4-fpm
WORKDIR "/application"

COPY docker/php-config/php-ini-overrides.ini /etc/php/8.4/fpm/conf.d/99-overrides.ini

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php8.4-xdebug php8.4-intl php8.4-bcmath \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./composer.* ./
COPY ./.env ./

RUN /usr/bin/composer install --no-scripts

RUN chown -R ubuntu:ubuntu /application
