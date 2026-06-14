FROM php:8.2-apache

# Install mysqli & pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy semua file ke web root
COPY . /var/www/html/

# Set permission (penting)
RUN chown -R www-data:www-data /var/www/html

# Aktifkan rewrite (kalau pakai routing)
RUN a2enmod rewrite
