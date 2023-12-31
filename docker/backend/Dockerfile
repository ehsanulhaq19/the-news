FROM php:8.0-fpm

# Install dockerize so we can wait for containers to be ready
ENV DOCKERIZE_VERSION 0.6.1

RUN curl -s -f -L -o /tmp/dockerize.tar.gz https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-linux-amd64-v$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf /tmp/dockerize.tar.gz \
    && rm /tmp/dockerize.tar.gz

# Install Composer
ENV COMPOSER_VERSION 2.1.5

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libssl-dev \
        libzip-dev \
        unzip \
        zip \
        netcat \
        default-mysql-client \
        cron \
    && apt-get clean \
    && pecl install redis \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*;

COPY ./docker/backend/laravel.ini /usr/local/etc/php/conf.d/laravel.ini

WORKDIR /usr/src/app

# Copy Laravel files to the container
COPY ./backend .

# Install Laravel dependencies
RUN composer install

# Set permissions for Laravel storage and bootstrap cache folders
RUN chown -R www-data:www-data storage bootstrap/cache

COPY ./docker/backend/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]

# Copy the Laravel scheduler cron file
COPY ./docker/backend/crontab /etc/cron.d/laravel-cron

# Set permissions for the cron file
RUN chmod 0644 /etc/cron.d/laravel-cron

# Enable the cron job
RUN crontab /etc/cron.d/laravel-cron

# Run PHP-FPM and start cron service in the foreground
CMD ["sh", "-c", "service cron start && php-fpm"]
