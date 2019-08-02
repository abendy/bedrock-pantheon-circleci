FROM php:7.1-fpm
# FROM php:${PHP_VERSION:-latest}

# Replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

# Make sure apt is up to date
RUN apt-get update --fix-missing

# Install bits
RUN apt-get install -y curl
RUN apt-get install -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev

# Install PHP gd library
RUN docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

# Install MySQLi
RUN docker-php-ext-install mysqli

# Install composer
RUN curl -sS https://getcomposer.org/installer | /usr/local/bin/php -- --install-dir=/usr/local/bin --filename=composer

# Install wp-cli
RUN curl -o /bin/wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x /bin/wp-cli.phar
RUN cd /bin && mv wp-cli.phar wp
