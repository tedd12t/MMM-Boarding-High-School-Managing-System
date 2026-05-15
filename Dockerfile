FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    zip unzip git curl

RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --optimize-autoloader --ignore-platform-reqs --no-scripts

# THE PERMISSION FIX
RUN mkdir -p /var/www/html/storage/app/purify/HTML
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

# We added 'permission:cache-reset' and 'view:clear' to ensure no 500 errors
CMD php artisan package:discover --ansi && \
    php artisan migrate:fresh --seed --force && \
    php artisan permission:cache-reset && \
    php artisan view:clear && \
    php artisan config:cache && \
    apache2-foreground