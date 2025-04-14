FROM php:8.4-apache

RUN apt-get update && apt-get install -y curl gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite

WORKDIR /var/www/html
RUN npm install && npm run build

EXPOSE 80

CMD ["apache2-foreground"]
