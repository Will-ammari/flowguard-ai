FROM php:7.4-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts

COPY . .

RUN composer dump-autoload

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000