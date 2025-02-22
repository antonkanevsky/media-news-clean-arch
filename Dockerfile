#########################
### Scratch image ###
#########################
FROM php:8.3-fpm-alpine3.21 AS scratch

RUN set -x \
    && apk add --no-cache --virtual .build-deps postgresql-dev \
    && apk add --update linux-headers \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql \
    && apk add --no-cache postgresql-libs \
    && apk add --no-cache git \
    && apk del .build-deps

RUN set -x \
    && apk add --no-cache --virtual .build-deps libxml2-dev \
    && apk del .build-deps

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . /var/www/html

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

ENV COMPOSER_VERSION 2.7.2
RUN set -x \
    && curl --silent --show-error --retry 5 https://getcomposer.org/installer \
        | php -- --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION}

RUN apk add --no-cache bash

#########################
### Development image ###
#########################
FROM scratch AS development

ARG XDEBUG_ENABLE
ENV XDEBUG_VERSION 3.3.1
RUN set -x \
    && mkdir -p /usr/src/php/ext/xdebug \
    && curl "https://pecl.php.net/get/xdebug/${XDEBUG_VERSION}" \
        | tar xvz --directory=/usr/src/php/ext/xdebug --strip=1 \
    && docker-php-ext-install -j$(nproc) xdebug \
    && rm -rf /usr/src/php/ext/xdebug

COPY ./docker/xdebug.ini /usr/local/etc/php/xdebug.ini
RUN \
if [ "${XDEBUG_ENABLE}" == "1" ] ; \
  then cp /usr/local/etc/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini; \
fi

FROM nginx:1.27-alpine3.21 AS nginx

COPY ops/nginx/symfony.conf.template /etc/nginx/templates/default.conf.template

ENV LISTEN_PORT 80
