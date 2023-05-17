# Use the official PHP base image
FROM php:latest

# Set the working directory in the container
WORKDIR /workspace/Deploy-web-app-to-connect-aws-dynamodb-data

# Copy the PHP files and composer.json/composer.lock (if needed) to the container
COPY . //workspace/Deploy-web-app-to-connect-aws-dynamodb-data

# Expose port 80 for web server
EXPOSE 80

# Start the PHP development server
CMD ["php", "-S", "0.0.0.0:80", "-t", "/workspace/Deploy-web-app-to-connect-aws-dynamodb-data"]
