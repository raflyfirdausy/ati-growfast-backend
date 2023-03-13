FROM php:8.0.14-fpm

COPY ./app /home/ati-growfast
RUN chown -R www-data /home/ati-growfast

WORKDIR /home/ati-growfast

RUN apt-get update
RUN apt-get install -y zip curl libzip-dev libpng-dev libpq-dev zlib1g-dev unzip
RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:2.5.4 /usr/bin/composer /usr/local/bin/composer
# RUN composer update 
# RUN composer self-update
# RUN composer install 

# SETUP PHP-FPM CONFIG SETTINGS (max_children / max_requests)
# https://serverfault.com/questions/884256/how-and-where-to-configure-pm-max-children-for-php-fpm-with-docker
RUN echo 'pm.max_children = 50' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.start_servers = 5' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_requests = 5000' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.min_spare_servers = 5' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_spare_servers = 35' >> /usr/local/etc/php-fpm.d/zz-docker.conf

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 9000
CMD bash -c "composer self-update && composer install && php-fpm"
# CMD ["php-fpm"]