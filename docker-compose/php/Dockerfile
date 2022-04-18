FROM php:8.0.5-fpm

# Variáveis definidas no docker-compose.yml
ARG user
ARG uid

# Instalando as dependências
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libcurl3-dev \
    libcurl4-openssl-dev \
    libldb-dev \
    libldap2-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    libc-dev \
    libmagickwand-dev \
    autoconf \
    pkg-config \
    zip \
    unzip \
    software-properties-common \
    python3-pip \
    vim
    
 

#Pacotes libreoffice para converter pdf
#RUN apt-get install -y libreoffice-writer --no-install-recommends --no-install-suggests

# Limpando o cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalando Extensões PHP
RUN docker-php-ext-install curl gd intl ldap mbstring opcache pdo_pgsql xml zip

RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/5.3.2.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-5.3.2 /usr/src/php/ext/redis \
    && docker-php-ext-install redis


ARG IMAGICK_LAST_COMMIT='448c1cd0d58ba2838b9b6dff71c9b7e70a401b90'

RUN mkdir -p /usr/src/php/ext/imagick && \
    curl -fsSL https://github.com/Imagick/imagick/archive/${IMAGICK_LAST_COMMIT}.tar.gz | tar xvz -C /usr/src/php/ext/imagick --strip 1 && \
    docker-php-ext-install imagick
    

# Copiando última versão do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criando usuário do sistema para rodar comandos Composer e php
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
    

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=develop,coverage,debug,profile" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.start_with_request=yes" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.client_host=172.17.0.1" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.idekey=VSCODE" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.remote_port=9003" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.default_enable=on" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.remote_log=/var/www/web/xdebug.log" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.discover_client_host=true" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null

#RUN pip3 install pandas

#RUN pip3 install selenium

#RUN pip3 install requests


# Setando diretório de trabalho
WORKDIR /var/www

ENTRYPOINT ["php-fpm"]
EXPOSE 9000
USER $user
