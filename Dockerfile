# Sử dụng PHP 7.4 với Apache
FROM php:7.4-apache

# Cài đặt extension mysqli để kết nối database
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy source code vào thư mục web root của container
COPY ./src /var/www/html/

# Mở cổng 80
EXPOSE 80