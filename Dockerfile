FROM php:8.2-cli

# 1. Instalar dependencias del sistema (Git, Curl, Node, NPM y librerías para PHP)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# 2. Instalar extensiones de PHP fundamentales para Laravel y MySQL
RUN docker-php-ext-install pdo pdo_mysql bcmath gd

# 3. Traer Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Definir carpeta de trabajo
WORKDIR /app

# 5. Copiar todo el código de tu proyecto
COPY . .

# 6. Instalar librerías de PHP (Composer)
RUN composer install --no-dev --optimize-autoloader

# 7. Instalar librerías de JS y compilar los estilos (Vite)
# Esto arreglará que tu página se vea con diseño y no solo texto azul
RUN npm install
RUN npm run build

# 8. Dar permisos correctos para que Laravel pueda escribir caché
RUN chmod -R 775 storage bootstrap/cache

# 9. Comando de inicio usando el puerto que Render asigna automáticamente
CMD php artisan serve --host=0.0.0.0 --port=$PORT
