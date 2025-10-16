FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql \
 && a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 80

HEALTHCHECK --interval=30s --timeout=3s \
  CMD php -r 'exit(extension_loaded("pdo_mysql")?0:1);'

