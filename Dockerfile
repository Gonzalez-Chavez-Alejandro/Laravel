FROM php:8.2-cli

# instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    nodejs \
    npm

# instalar extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql

# instalar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

RUN npm install && npm run build

RUN chmod -R 775 storage bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT