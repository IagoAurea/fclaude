FROM php:8.2-fpm

# Set working directory
WORKDIR /usr/src/app

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_pgsql zip exif pcntl gd memcached opcache sockets && \
    docker-php-ext-install bcmath

RUN mkdir /usr/local/bin -p

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && mv composer /usr/local/bin/composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

USER $user

COPY --chown=1000:1000 ./laravel /usr/src/app

RUN composer install

RUN PATH=$PATH:/usr/src/app/vendor/bin:bin

EXPOSE 6001