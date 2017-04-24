FROM php:7-fpm

MAINTAINER Golubev Dmitrii "shotonoff@gmail.com"

RUN apt-get update

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install opcache

RUN apt-get install -y libicu-dev
RUN pecl install intl
RUN docker-php-ext-install intl

RUN apt-get install sendmail -y

COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN rm -rf /var/lib/apt/lists/ *