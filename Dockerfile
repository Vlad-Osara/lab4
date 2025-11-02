# Sử dụng image PHP có Apache
FROM php:8.2-apache

# Cài lib cần thiết và composer
RUN apt-get update && apt-get install -y \
    libpq-dev unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Copy toàn bộ mã nguồn
COPY . /var/www/html/

# Cài đặt thư viện PHP qua composer
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# (Nếu index nằm trong public/)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Mở port 80
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]
