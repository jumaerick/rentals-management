# Use PHP 7.4 as the base image
FROM php:7.4-cli

# Update package list and install necessary dependencies
RUN apt-get update -y && apt-get install -y \
    libonig-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-install pdo mbstring

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies using Composer
RUN composer install

# Expose port
EXPOSE 8000

# Command to run the Laravel application
CMD php artisan serve --host=0.0.0.0 --port=8000