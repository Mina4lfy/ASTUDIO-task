ARG PHP_VERSION="8.1"

FROM php:${PHP_VERSION}-fpm-alpine

# RUN set -ex \
# 	&& apk --no-cache add \
#     supervisor \
#     postgresql-libs \
#     postgresql-dev \
# 	&& docker-php-ext-install pgsql pdo_pgsql \
# 	&& apk del postgresql-dev

RUN apk --no-cache --update --repository http://dl-cdn.alpinelinux.org/alpine/v$ALPINE_VERSION/main/ add \
  # postgresql-dev \
  supervisor

# Install system dependencies
RUN apk update && apk --no-cache add \
  supervisor \
  libzip-dev \
  zip \
  unzip \
  && docker-php-ext-install zip pdo_mysql mysqli pcntl

RUN adduser -D -u 1000 -G www-data laravel \
  && chown -R laravel:www-data /home/laravel

RUN mkdir -p "/etc/supervisor/logs" \
  && chmod -R 777 "/etc/supervisor/logs" \
  && chown -R laravel:www-data "/etc/supervisor/logs" \
  && touch "/etc/supervisor/logs/supervisord.log"

# COPY ./devops/supervisord/supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]

# USER laravel