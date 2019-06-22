FROM php:7-apache 
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug \
	&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini
RUN sed -i 's/-Indexes/+Indexes/' /etc/apache2/conf-enabled/docker-php.conf

