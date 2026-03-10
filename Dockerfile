FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    nodejs \
    npm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install
RUN npm install && npm run build

CMD php artisan serve --host=0.0.0.0 --port=$PORT