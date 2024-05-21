FROM php:7.3.27-fpm-alpine3.12

RUN apk add --no-cache git openssl shadow bash mysql-client nodejs npm
RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
RUN rm -rf /var/www/html
RUN ln -s public html

RUN chown -R www-data:www-data /var/www
RUN usermod -u 1000 www-data
USER www-data

EXPOSE 9000

ENTRYPOINT ["php-fpm"]