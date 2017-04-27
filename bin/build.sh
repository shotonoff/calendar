#!/usr/bin/env bash

    if [ -z $(which docker) ]; then
        echo "Docker is not installed"
        exit -1
    fi

    if [ -z $(which docker-compose) ]; then
        echo "Docker-compose is not installed"
        exit -1
    fi

    if [[ -z "$(docker network ls | grep aulinks)" ]];then
        docker network create --driver bridge aulinks
    fi

	docker pull digitallyseamless/nodejs-bower-grunt:latest
	docker-compose pull mysql nginx
	docker-compose build php
	bin/run npm install
	bin/run bower install
	bin/run grunt bowercopy
	bin/run composer install

	docker-compose up -d

	sleep 5

    docker-compose exec mysql mysql -uroot -proot -e "drop database if exists aulinks_db; create database aulinks_db;"
    docker-compose exec php ./vendor/bin/doctrine-migrations migrations:migrate --no-interaction
	docker-compose exec php ./bin/console user:create admin admin@aulinks.cz --super