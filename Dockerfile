FROM php:7.1-fpm

# install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    sqlite3 \
    libsqlite3-dev

# configure and install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    mbstring \
    zip \
    opcache \
    pdo_sqlite

# configure and install GD library
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# add user and set permissions
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

# copy application code
COPY . /var/www/html

# install composer dependencies
RUN composer install --optimize-autoloader

# set storage and cache permissions
RUN chmod -R 777 storage/ bootstrap/cache/

# expose port 9000 and start php-fpm server
EXPOSE 9000
CMD [ "php-fpm"]
