FROM php:7-fpm

MAINTAINER Golubev Dmitrii "shotonoff@gmail.com"

RUN apt-get update

RUN docker-php-ext-install pdo pdo_mysql opcache

RUN apt-get install sendmail -y

RUN rm -rf /var/lib/apt/lists/ *

RUN mkdir /var/log/aulinks
RUN chmod -R 0777 /var/log/aulinks

RUN mkdir /var/cache/aulinks
RUN chmod -R 0777 /var/cache/aulinks

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"