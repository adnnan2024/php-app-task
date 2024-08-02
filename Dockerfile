# Use the official PHP image as a base
FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy application source code to the Apache document root
COPY . /var/www/html/

# Provide write permissions to the Apache document root
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]



