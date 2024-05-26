FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl \
    npm

# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install and run npm

RUN chown www-data:www-data -R ./
# RUN mkdir -p /root/.npm/_logs && chown www-data:www-data -R /root/.npm

# Install Node.js and npm
# RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
#    apt-get install -y nodejs

# Generate Laravel Mix assets
# RUN npm run production

# Set working directory
WORKDIR /var/www/html/
