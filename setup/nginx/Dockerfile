FROM nginx:latest

RUN apt-get update && apt-get install vim -y

COPY certs/localhost.crt /etc/ssl/certs/
COPY certs/localhost.key /etc/ssl/private/
COPY certs/dhparam.pem /etc/ssl/private/

ARG SCHEME

COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d/app.${SCHEME}.conf /etc/nginx/conf.d/

ARG DOCKER_USER
ARG DOCKER_GROUP
ARG DOCKER_USER_ID
ARG DOCKER_GROUP_ID

RUN addgroup ${DOCKER_GROUP} --gid ${DOCKER_GROUP_ID} && \
    adduser ${DOCKER_USER} --uid ${DOCKER_USER_ID} --gid ${DOCKER_GROUP_ID} --disabled-password --gecos ''

WORKDIR /var/www/html