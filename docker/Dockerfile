FROM php:8.2-fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions zip bcmath pdo pdo_mysql intl xdebug @composer; \
    rm /usr/local/bin/install-php-extensions;

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

COPY ./ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

RUN composer install --ignore-platform-reqs --no-scripts


EXPOSE 8000
CMD ["php-fpm"]