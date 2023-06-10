FROM php:latest

RUN apt-get update

RUN apt-get install -y  \
    libmcrypt-dev  \
    libjpeg-dev  \
    libpng-dev  \
    libfreetype6-dev  \
    zlib1g-dev  \
    libzip-dev \
    libonig-dev \
    openssl \
    fontconfig \
    libxrender1 \
    xfonts-75dpi \
    xfonts-base
#    nginx

RUN wget -q https://github.com/wkhtmltopdf/wkhtmltopdf/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.stretch_amd64.deb \
    && dpkg -i wkhtmltox_0.12.6-1.stretch_amd64.deb \
    && apt-get -f install -y \
    && rm wkhtmltox_0.12.6-1.stretch_amd64.deb

RUN docker-php-ext-configure \
    gd --with-freetype --with-jpeg

RUN docker-php-ext-install -j$(nproc) \
    mbstring \
    gd \
    iconv \
    zip


RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY app /app
# RUN composer install
RUN composer install --no-dev --optimize-autoloader

# COPY nginx.conf /etc/nginx/conf.d/default.conf
# RUN rm -rf /var/www/html/*

# CMD service php-fpm start && nginx -g "daemon off;"
CMD php -S 0.0.0.0:80 -t /app