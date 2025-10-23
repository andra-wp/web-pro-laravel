# Gunakan base image PHP yang sudah ada FPM
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependency sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy file composer dan install dependency
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy semua file Laravel
COPY . .

# Set permission folder storage & cache
RUN chmod -R 777 storage bootstrap/cache

# Laravel biasanya butuh APP_KEY, nanti Render inject dari Environment Variables
# Jangan jalankan php artisan key:generate di sini!

# Expose port (Render akan pakai $PORT, bukan hardcoded port)
EXPOSE 8080

# Jalankan Laravel pakai PHP built-in server
CMD php artisan serve --host=0.0.0.0 --port=$PORT
