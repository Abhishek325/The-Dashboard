FROM php:5.5-apache

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
