FROM php:8.1-fpm

# Variáveis definidas no docker-compose.yml
ARG user
ARG uid

ENV TZ=America/Sao_Paulo

# Instalando as dependências
RUN apt-get update && apt-get install -y \
    curl \
    libcurl3-dev \
    libcurl4-openssl-dev \
    libldb-dev \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    libc-dev \
    libmagickwand-dev \
    zip \
    unzip \
    vim



#Pacotes libreoffice para converter pdf
#RUN apt-get install -y libreoffice-writer --no-install-recommends --no-install-suggests

# Limpando o cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalando Extensões PHP
#RUN docker-php-ext-install curl gd intl mbstring opcache pdo_pgsql xml zip
RUN docker-php-ext-install curl gd intl mbstring opcache pdo_pgsql zip

#ARG IMAGICK_LAST_COMMIT='448c1cd0d58ba2838b9b6dff71c9b7e70a401b90'

#RUN mkdir -p /usr/src/php/ext/imagick && \
#    curl -fsSL https://github.com/Imagick/imagick/archive/${IMAGICK_LAST_COMMIT}.tar.gz | tar xvz -C /usr/src/php/ext/imagick --strip 1 && \
#    docker-php-ext-install imagick


# Copiando última versão do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criando usuário do sistema para rodar comandos Composer e php
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


# Instalação de extensões
RUN pecl install  apcu \
    xdebug \
    && docker-php-ext-enable xdebug


# Setando diretório de trabalho
WORKDIR /var/www

ENTRYPOINT ["php-fpm"]
EXPOSE 9000
USER $user