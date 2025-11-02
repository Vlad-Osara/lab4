# Sử dụng image PHP có Apache sẵn
FROM php:8.2-apache

# Cài thư viện cần thiết để build pdo_pgsql
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy mã nguồn vào thư mục web của Apache
COPY public/ /var/www/html/

# Mở port 80
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]
