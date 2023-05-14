FROM mcr.microsoft.com/devcontainers/php:0-8.0

# install php extensions
RUN docker-php-ext-install bcmath

# disable xdebug
RUN rm -f /usr/local/etc/php/conf.d/xdebug.ini