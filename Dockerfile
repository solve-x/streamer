FROM php:7.0-cli

# RUN pecl install xdebug;
# RUN yes | pecl install xdebug

FROM buildpack-deps:stretch

# Versions of Nginx and nginx-rtmp-module to use
ENV NGINX_VERSION nginx-1.11.3
ENV NGINX_RTMP_MODULE_VERSION 1.1.9

# Install dependencies
RUN apt-get update && \
    apt-get install -y ca-certificates \
        zip \
        openssl \
        libssl1.0-dev \
        git \
        nano \
        php \
        zip \
        php-mbstring \
        php-xml \
        php7.0-fpm \
        php7.0-xdebug \
        php7.0-mysql && \
    rm -rf /var/lib/apt/lists/*

# Download and decompress Nginx
RUN mkdir -p /tmp/build/nginx && \
    cd /tmp/build/nginx && \
    wget -O ${NGINX_VERSION}.tar.gz https://nginx.org/download/${NGINX_VERSION}.tar.gz && \
    tar -zxf ${NGINX_VERSION}.tar.gz

# Download and decompress RTMP module
RUN mkdir -p /tmp/build/nginx-rtmp-module && \
    cd /tmp/build/nginx-rtmp-module && \
    wget -O nginx-rtmp-module-${NGINX_RTMP_MODULE_VERSION}.tar.gz https://github.com/arut/nginx-rtmp-module/archive/v${NGINX_RTMP_MODULE_VERSION}.tar.gz && \
    tar -zxf nginx-rtmp-module-${NGINX_RTMP_MODULE_VERSION}.tar.gz && \
    cd nginx-rtmp-module-${NGINX_RTMP_MODULE_VERSION}

# Build and install Nginx
# The default puts everything under /usr/local/nginx, so it's needed to change
# it explicitly. Not just for order but to have it in the PATH
RUN cd /tmp/build/nginx/${NGINX_VERSION} && \
    ./configure \
        --sbin-path=/usr/local/sbin/nginx \
        --conf-path=/etc/nginx/nginx.conf \
        --error-log-path=/var/log/nginx/error.log \
        --pid-path=/var/run/nginx/nginx.pid \
        --lock-path=/var/lock/nginx/nginx.lock \
        --http-log-path=/var/log/nginx/access.log \
        --http-client-body-temp-path=/tmp/nginx-client-body \
        --with-http_ssl_module \
        --with-threads \
        --with-ipv6 \
        --add-module=/tmp/build/nginx-rtmp-module/nginx-rtmp-module-${NGINX_RTMP_MODULE_VERSION} && \
    make -j $(getconf _NPROCESSORS_ONLN) && \
    make install && \
    mkdir /var/lock/nginx && \
    rm -rf /tmp/build

# Forward logs to Docker
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log

# Set up config file
COPY nginx.conf /etc/nginx/nginx.conf
COPY xdebug.ini /etc/php/7.0/mods-available/
#RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/no-debug-non-zts-20151012/ -name xdebug.so)" > /etc/php/7.0/fpm/conf.d/xdebug.ini \
#    && echo "xdebug.remote_enable=on" >> /etc/php/7.0/fpm/conf.d/xdebug.ini \
#    && echo "xdebug.remote_autostart=off" >> /etc/php/7.0/fpm/conf.d/xdebug.ini

#RUN curl -sS https://getcomposer.org/installer | php && \
#    cp composer.phar /usr/local/bin/composer

#RUN php composer.phar create-project laravel/laravel /usr/local/nginx/public

RUN phpenmod pdo_mysql && \
    service php7.0-fpm reload

#RUN chown www-data:www-data -R /usr/local/nginx/public && \
#    chmod -R 775 /usr/local/nginx/public/storage

EXPOSE 1935

ENTRYPOINT service php7.0-fpm start && nginx -g "daemon off;"
