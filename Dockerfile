# Usamos una imagen que ya tiene PHP 8.2 y Nginx configurados para Laravel
FROM richarvey/nginx-php-fpm:latest

# Copiamos todo tu código al servidor
COPY . /var/www/html

# Configuraciones necesarias para Render y Laravel
ENV SKIP_COMPOSER 0
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV WEBROOT /var/www/html/public
ENV COMPOSER_ALLOW_SUPERUSER 1

# Comando para arrancar el servidor (Nginx + PHP)
CMD ["/start.sh"]
