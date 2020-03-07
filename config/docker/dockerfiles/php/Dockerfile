# (https://github.com/docker-library/wordpress/blob/0df5de06a4/php7.4/fpm-alpine/Dockerfile)

ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine

# Add nginx user:group
RUN set -ex \
  && addgroup -S nginx \
  && adduser -D -H -S -G nginx nginx

# Update & upgrade packages
RUN apk --quiet --no-cache update \
  && apk --quiet --no-cache upgrade

# Set timezone
ARG TZ
RUN apk --quiet --no-cache update \
  && apk --quiet --no-cache upgrade \
  && apk --quiet --no-cache add tzdata \
  && cp "/usr/share/zoneinfo/$TZ" /etc/localtime \
  && echo "$TZ" > /etc/timezone

# Install PHPize dependencies
# (https://github.com/docker-library/php/issues/412)
RUN apk --quiet --no-cache update \
  && apk --quiet --no-cache upgrade \
  && apk add --quiet --no-cache $PHPIZE_DEPS

# Install tooling
RUN apk add --quiet --no-cache \
# in theory, docker-entrypoint.sh is POSIX-compliant, but priority is a working, consistent image
  bash \
# BusyBox sed is not sufficient for some of our sed expressions
  sed \
# Ghostscript is required for rendering PDF previews
  ghostscript \
  gzip \
  mysql-client \
  pwgen

# PHP extensions
# (https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions)
RUN apk add --quiet --no-cache --virtual .build-deps \
  freetype-dev \
  libjpeg-turbo-dev \
  libpng-dev \
  libzip-dev \
  && docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/freetype2 \
    --with-jpeg-dir=/usr/lib \
    &> /dev/null \
  && docker-php-ext-install \
    bcmath \
    exif \
    gd \
    zip \
    &> /dev/null
RUN apk del .build-deps &> /dev/null

# Install memcached
ARG MEMCACHED_EXT_VERSION
RUN apk add --quiet --no-cache libmemcached-dev zlib-dev \
  && yes "" | pecl install memcached-"${MEMCACHED_EXT_VERSION}" &> /dev/null \
  && docker-php-ext-enable memcached &> /dev/null

# Install mysqli
RUN docker-php-ext-install mysqli &> /dev/null

# Install opcache
RUN docker-php-ext-install opcache &> /dev/null

# Install redis
ARG REDIS_EXT_VERSION
RUN yes "" | pecl install redis-"${REDIS_EXT_VERSION}" &> /dev/null \
  && docker-php-ext-enable redis &> /dev/null

# Install Wp-Cli
RUN curl -Ss -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
  && chmod +x /usr/local/bin/wp

# Install dotenv plugin for Wp-Cli
# (https://github.com/aaemnnosttv/wp-cli-dotenv-command)
RUN php -d memory_limit=2048M "$(which wp)" --allow-root package install aaemnnosttv/wp-cli-dotenv-command:^1.0 &> /dev/null

# Install xdebug
ARG XDEBUG_EXT_VERSION
RUN yes "" | pecl install xdebug-"${XDEBUG_EXT_VERSION}" &> /dev/null \
  && docker-php-ext-enable xdebug &> /dev/null

# Assign ownership to user nginx
RUN chown -R nginx:nginx /var/www/html

WORKDIR /var/www/html

# Environment variables for WordPress host/database config
ENV WP_HOME ${WP_HOME}
ENV WP_HOST ${WP_HOST}
ENV WP_PORT ${WP_PORT}

ENV DB_NAME ${DB_NAME}
ENV DB_USER ${DB_USER}
ENV DB_PASSWORD ${DB_PASSWORD}
ENV DB_HOST ${DB_HOST}
ENV DB_PORT ${DB_PORT}
ENV DB_CHARSET ${DB_CHARSET}
ENV DB_PREFIX ${DB_PREFIX}
ENV CACHE_HOST ${REDIS_HOST}
ENV CACHE_PORT ${REDIS_PORT}
ENV CACHE_PASSWORD ${REDIS_PASSWORD}
ENV XDEBUG_CONFIG ${XDEBUG_CONFIG}

COPY ./scripts/php/configure-env /usr/local/bin/
RUN chmod +x /usr/local/bin/configure-env

ENTRYPOINT ["configure-env"]

CMD ["php-fpm"]
