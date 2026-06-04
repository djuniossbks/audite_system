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
CMD php artisan migrate --force && php artisan tinker --execute="if(\\\App\\\Models\\\User::where('email', 'djuniossbks@gmail.com')->doesntExist()) { \\\App\\\Models\\\User::create(['name' => 'Djunioss', 'email' => 'djuniossbks@gmail.com', 'password' => \\\Illuminate\\\Support\\\Facades\\\Hash::make(env('DB_PASSWORD')), 'role' => 'admin']); }" && php artisan serve --host=0.0.0.0 --port=$PORT
