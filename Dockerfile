FROM php:8.1-apache

RUN a2enmod ssl
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

ENV PATH "$PATH:./vendor/bin"

#------------------------------------------------
# Add Xdebug
#------------------------------------------------
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN mkdir /usr/local/etc/php/conf.d2/
RUN touch /usr/local/etc/php/conf.d2/php.ini
RUN ln -s /usr/local/etc/php/conf.d2/php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
