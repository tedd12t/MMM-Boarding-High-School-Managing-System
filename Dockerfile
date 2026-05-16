FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    zip unzip git curl

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --optimize-autoloader --ignore-platform-reqs --no-scripts

# --- THE CRITICAL PERMISSION FIX ---
# Create ALL necessary subfolders first
RUN mkdir -p storage/app/public \
    storage/app/purify/HTML \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Give full ownership to the web server user
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
# -----------------------------------

# Configure Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

# Final Startup Command: Syncs logic, updates your credentials, and starts the server
CMD php artisan package:discover --ansi && \
    php artisan migrate --force && \
    php artisan config:clear && \
    php artisan view:clear && \
    php artisan cache:clear && \
    php artisan tinker --execute="\$u=\App\Models\User::where('role', 'admin')->first() ?: \App\Models\User::first(); if(\$u) { \$u->email='admin@MMM.com'; \$u->password=bcrypt('password'); \$u->save(); }" && \
    apache2-foreground
