FROM php:8.2-fpm

# Set working directory
WORKDIR /usr/src/app

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_pgsql zip exif pcntl gd memcached opcache sockets

# Install dependencies
RUN apt-get update && apt-get install -y \
# RUN apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    nginx \
    # NEW LINE
    procps \
    libzip-dev \
    libcurl4-openssl-dev

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -

RUN apt-get install -y nodejs

# RUN npm install npm@7.24.2
RUN curl -L https://www.npmjs.com/install.sh | npm_install="7.24.2" sh

#New line
RUN pecl channel-update pecl.php.net  
RUN pecl install swoole
RUN docker-php-ext-enable swoole

RUN docker-php-ext-install bcmath

# SETUP PHP-FPM CONFIG SETTINGS (max_children / max_requests)
RUN echo 'pm.max_children = 15' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_requests = 500' >> /usr/local/etc/php-fpm.d/zz-docker.conf

RUN mkdir /usr/local/bin -p

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && mv composer /usr/local/bin/composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=1000:1000 ./laravel /usr/src/app

# add root to www group
RUN chmod -R 777 /usr/src/app/storage

USER $user

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY ./docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN docker-php-ext-install bcmath

# Deployment steps
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN set -eux

RUN composer install

# RUN dir ./laravel && npm install --save-dev chokidar && npm i --legacy-peer-deps

RUN npm install --save-dev chokidar

# RUN npm i chokidar

RUN npm i --legacy-peer-deps

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin
