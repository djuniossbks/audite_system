FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 10000

# Une seule ligne CMD qui exécute la migration PUIS lance le serveur
CMD php artisan migrate --force --seed && php artisan serve --host=0.0.0.0 --port=$PORT
