FROM php:7.3.10-apache

COPY . /var/www/html

RUN apt-get update && apt-get install -y libz-dev libpng-dev libzip-dev \
	&&  docker-php-ext-install pdo_mysql gd zip
RUN apt-get -y install curl gnupg

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

EXPOSE 80

WORKDIR /var/www/html
RUN composer require
RUN chmod -R 777 storage && chmod -R 777 bootstrap/cache
