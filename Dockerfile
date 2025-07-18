FROM php:8.3-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    vim \
    gnupg \
    ca-certificates \
    lsb-release

# Instala extensões PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring zip opcache

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js e npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Configurações do PHP
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/max_execution_time = 30/max_execution_time = 120/' "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/memory_limit = 128M/memory_limit = 512M/' "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/post_max_size = 8M/post_max_size = 64M/' "$PHP_INI_DIR/php.ini" \
 && sed -E -i -e 's/upload_max_filesize = 2M/upload_max_filesize = 64M/' "$PHP_INI_DIR/php.ini" \
 && echo "opcache.enable=1" >> "$PHP_INI_DIR/php.ini"

# Define o diretório de trabalho
WORKDIR /var/www/html

# COPY ["package.json", "package-lock.json", "/var/www/html/"]

# Copia todos os arquivos do projeto Laravel para o container
COPY . .

RUN cp .env.example .env

# Roda o composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Gera chave da aplicação
RUN php artisan key:generate

# Permissões corretas
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]
