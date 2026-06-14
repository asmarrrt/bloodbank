FROM php:8.2-apache

# Install mysqli & pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project
COPY . /var/www/html/

# Set working dir
WORKDIR /var/www/html

# Expose port
EXPOSE 80

web: apache2-foreground
