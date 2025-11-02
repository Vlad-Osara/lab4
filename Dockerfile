# Dùng image PHP 8.2 với Apache
FROM php:8.2-apache

# Cài extension PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Copy toàn bộ source code vào thư mục web của Apache
COPY . /var/www/html/

# Mở port 80
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]