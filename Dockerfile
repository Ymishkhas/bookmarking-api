# Use an official PHP image with Apache as the base image
FROM php:8.2-apache

# Install required PHP extensions for database access
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get clean

# Enable Apache mod_rewrite (needed for clean URLs in some PHP apps)
RUN a2enmod rewrite

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the 'api', 'db', and 'models' folders from the host to the container
COPY ./api /var/www/html/api/
COPY ./db /var/www/html/db/
COPY ./models /var/www/html/models/

# Set proper permissions for the web server to access files
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose port 80 to allow communication with the container
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]