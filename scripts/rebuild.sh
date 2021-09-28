#!/bin/bash
if [ -f .env ]
then
    export $(cat .env | sed 's/#.*//g' | xargs -d '\n')
fi

docker-compose down
COMPOSE_DOCKER_CLI_BUILD=0 \
docker-compose build --parallel && \
docker-compose up -d --force-recreate

if [[ $APP_ENV = 'production' ]]
then
pkill -f docker-compose -9 && \
docker-compose logs -t -f \
    | grep -v '\-HealthChecker' \
    | grep -v 'Health\-Check' \
    | grep -v '172.23.0' \
    | ./scripts/docker-logs-localtime \
    > /var/log/docker/sunnyview.log &
fi