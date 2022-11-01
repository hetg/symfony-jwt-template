FROM php:7.4-fpm

ENV APP_DIR /var/www/app

RUN apt-get update && apt-get install -y git zip unzip libpq-dev libicu-dev

RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
     intl \
     pdo pdo_mysql

COPY --from=composer:2.4.4 /usr/bin/composer /usr/bin/composer

COPY ./docker/php-fpm/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR ${APP_DIR}

COPY ./docker/php-fpm/entrypoint.sh /entrypoint.sh

RUN chown -R www-data:www-data /var/www

RUN sed -i -e 's@zend_extension@;zend_extension@g' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENTRYPOINT ["/entrypoint.sh", "docker-php-entrypoint"]
CMD ["php-fpm"]
