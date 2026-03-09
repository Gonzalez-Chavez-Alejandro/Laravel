FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# Configuraciones base
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV COMPOSER_ALLOW_SUPERUSER 1

# Instalamos dependencias optimizando la memoria
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Compilamos assets de Vite
RUN npm install && npm run build

# Permisos correctos
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data /var/www/html

CMD ["/start.sh"]

