FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# On nettoie le cache composer local avant de l'installer pour éviter la saturation mémoire
RUN composer clear-cache && composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 10000

# Lancement fluide : migrations + seeders automatiques + exécution de l'application

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
