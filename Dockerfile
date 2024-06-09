FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/ideagen

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libgd-dev \
    nodejs \
	npm
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # update npm to last version
RUN npm i -g npm

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-external-gd
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/ideagen

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/ideagen

# Set correct permissions
RUN chown -R www:www /var/www/ideagen
RUN chmod -R 755 /var/www/ideagen

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Change current user to www
USER www

# Copy composer.lock and composer.json
#COPY composer.json composer.lock /var/www

# Copy env file from example
COPY .env.example .env

# Run Composer
RUN composer install

# run npm install and build
RUN npm install && npm run build

# Expose port 9000 and start php-fpm server
EXPOSE 9000
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
