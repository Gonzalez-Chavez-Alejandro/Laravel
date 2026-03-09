# Etapa 1: Build de Vite
FROM node:20 as node_builder

WORKDIR /app
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# Etapa 2: PHP
FROM php:8.2-fpm

WORKDIR /var/www
COPY . .

# copiar assets compilados
COPY --from=node_builder /app/public/build public/build

CMD ["php-fpm"]