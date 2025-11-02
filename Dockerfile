# Sử dụng image PHP có Apache sẵn
FROM php:8.2-apache

# Cài thư viện cần thiết để build pdo_pgsql
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy toàn bộ project
COPY . /var/www/html/

# Thay đổi DocumentRoot sang /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Mở port 80
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]
