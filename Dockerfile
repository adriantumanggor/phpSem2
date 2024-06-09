# Use the official PHP image from the Docker Hub
FROM php:8.1-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Enable Apache mod_rewrite module
RUN a2enmod rewrite

# Set file permissions
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 755 /var/www/html

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
