FROM php:8.2-cli

# Install system packages
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    zip \
    curl \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP packages
RUN composer install --no-interaction --prefer-dist

# Expose the HTTP port
EXPOSE 10000

# Start Lumen server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
