FROM richarvey/nginx-php-fpm:latest

# Copiamos el código
COPY . /var/www/html

# Configuraciones para que la imagen instale dependencias automáticamente
ENV SKIP_COMPOSER 0
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV WEBROOT /var/www/html/public
ENV COMPOSER_ALLOW_SUPERUSER 1

# Forzamos la instalación de dependencias de PHP y Node (Vite)
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Damos permisos a las carpetas de Laravel
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data /var/www/html

CMD ["/start.sh"]
