FROM php:8.2-apache

# Instala extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y unzip git zip curl default-mysql-client

# Ativa mod_rewrite
RUN a2enmod rewrite
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define diretório de trabalho dentro do container
WORKDIR /var/www/html

# Copia os arquivos do composer para aproveitar cache em builds futuros
COPY composer*.json ./

# Copia php.ini personalizado
COPY docker/php.ini /usr/local/etc/php/

# Instala dependências
# RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copia o restante do código
COPY . .

# Expõe a porta da aplicação
EXPOSE 80
