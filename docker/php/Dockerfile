FROM php:7-fpm

MAINTAINER Golubev Dmitrii "shotonoff@gmail.com"

RUN apt-get update

RUN apt-get install git git-core -y
RUN apt-get install -y zlib1g-dev

RUN docker-php-ext-install pdo pdo_mysql opcache zip

RUN apt-get install sendmail -y

RUN rm -rf /var/lib/apt/lists/ *

RUN mkdir /var/log/aulinks
RUN chmod -R 0777 /var/log/aulinks

RUN mkdir -p /var/cache/aulinks && mkdir /var/cache/spool
RUN chmod -R 0777 /var/cache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"