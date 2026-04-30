FROM php:8.4-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
    nodejs npm

# PHP extensions
RUN docker-php-ext-install \
    pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Work directory
WORKDIR /var/www

# Copy project
COPY . .

# Install backend dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Install frontend dependencies + build assets (FIX FOR VITE ERROR)
RUN npm install
RUN npm run build

# Fix Laravel permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000