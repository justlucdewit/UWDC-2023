FROM php:8.2-apache

RUN apt-get update -y && apt-get install -y openssl zip unzip zlib1g-dev libpq-dev libicu-dev libzip-dev curl libpng-dev nano git cron inetutils-ping
RUN docker-php-ext-install pdo zip gd exif mysqli

RUN a2enmod rewrite
WORKDIR /var/www/html/

COPY ./dist/ /var/www/html/
COPY ./backend/ /var/www/html/

RUN chown -R www-data.www-data *

RUN cd /var/www/html/

ENTRYPOINT ["/usr/local/bin/php", "-S", "0.0.0.0:80"]
