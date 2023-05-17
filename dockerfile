# Use the official PHP base image
FROM php:latest

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the PHP files and composer.json/composer.lock (if needed) to the container
COPY . /var/www/html

# Install the AWS SDK for PHP via Composer
RUN apt-get update && apt-get install -y unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev

# Expose port 80 for web server
EXPOSE 80

# Start the PHP development server
CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
