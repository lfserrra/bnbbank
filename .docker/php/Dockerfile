FROM php:8.1-fpm-alpine

RUN apk add --no-cache openssl bash git mysql-client
RUN docker-php-ext-install pdo pdo_mysql bcmath

WORKDIR /var/www

RUN rm -rf /var/www/html
RUN ln -s public html

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer

EXPOSE 9000

ENTRYPOINT ["php-fpm"]
