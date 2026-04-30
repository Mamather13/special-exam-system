FROM php:8.4-cli

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev \
    libpng-dev libonig-dev libxml2-dev \
    nodejs npm

# PHP extensions
RUN docker-php-ext-install \
    pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Install backend deps
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Install frontend deps + build assets
RUN npm install
RUN npm run build

# Permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000