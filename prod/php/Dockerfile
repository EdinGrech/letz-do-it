FROM php:7.4-apache

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy your project files to the container's web directory
COPY . /var/www/html

# Set directory permissions not recommended, be smart
RUN chown -R www-data:www-data /var/www/html/images