FROM ubuntu:focal

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y \
    gnupg gosu curl ca-certificates

RUN mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-key adv --homedir ~/.gnupg --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C300EE8C \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.0-cli php8.0-fpm php8.0-dev \
       php8.0-pgsql php8.0-sqlite3 php8.0-gd \
       php8.0-curl php8.0-memcached \
       php8.0-imap php8.0-mbstring \
       php8.0-xml php8.0-zip php8.0-bcmath php8.0-soap \
       php8.0-intl php8.0-readline php8.0-pcov \
       php8.0-msgpack php8.0-igbinary php8.0-ldap \
       php8.0-redis php8.0-swoole

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y yarn

# other useful packages
RUN apt-get install -y \
    zip unzip git supervisor postgresql-client php-xdebug vim-gtk3

# RUN apt-get install -y libcap2-bin \
#     && setcap "cap_net_bind_service=+ep" /usr/sbin/php-fpm8.0 \
#     && getcap /usr/sbin/php-fpm8.0

RUN yarn global add laravel-echo-server

RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ARG DOCKER_USER
ARG DOCKER_GROUP
ARG DOCKER_USER_ID
ARG DOCKER_GROUP_ID

RUN addgroup ${DOCKER_GROUP} --gid ${DOCKER_GROUP_ID} && \
    adduser ${DOCKER_USER} --uid ${DOCKER_USER_ID} --gid ${DOCKER_GROUP_ID} --disabled-password --gecos '' && \
    install -d -m 0777 -o ${DOCKER_USER} -g ${DOCKER_GROUP} \
        /home/${DOCKER_USER} \
        /run/supervisor

COPY supervisor/ /etc/supervisor/

COPY pool.d/ /etc/php/8.0/fpm/pool.d/

ARG XDEBUG_START_WITH_REQUEST
ARG XDEBUG_DISCOVER_CLIENT_HOST
ARG XDEBUG_MODE
ARG XDEBUG_CLIENT_HOST
ARG XDEBUG_CLIENT_PORT
ARG XDEBUG_IDEKEY

RUN printf "\
xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}\n\
xdebug.discover_client_host=${XDEBUG_DISCOVER_CLIENT_HOST}\n\
xdebug.mode=${XDEBUG_MODE}\n\
xdebug.client_host=${XDEBUG_CLIENT_HOST}\n\
xdebug.client_port=${XDEBUG_CLIENT_PORT}\n\
xdebug.idekey=${XDEBUG_IDEKEY}\n\
">> /etc/php/8.0/fpm/conf.d/20-xdebug.ini

USER ${DOCKER_USER}:${DOCKER_GROUP}

WORKDIR /var/www/html

ENTRYPOINT ["supervisord"]