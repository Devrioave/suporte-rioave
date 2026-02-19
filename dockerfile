# Stage 1: build frontend assets
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP-FPM + Nginx runtime
FROM php:8.4-fpm-alpine

RUN apk add --no-cache nginx libpng-dev libzip-dev zip unzip icu-dev \
    && docker-php-ext-install pdo_mysql gd zip intl bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY --from=assets /app/public/build ./public/build

# Production dependencies only
RUN composer install --no-dev --optimize-autoloader --no-scripts \
    && rm -f bootstrap/cache/*.php

RUN chown -R www-data:www-data storage bootstrap/cache public

RUN rm -rf /etc/nginx/http.d/*.conf
COPY ./docker/nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 80

CMD sh -c "rm -f bootstrap/cache/*.php && php artisan config:clear && php artisan route:clear && php-fpm -D && nginx -g 'daemon off;'"
