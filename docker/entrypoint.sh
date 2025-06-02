#!/bin/sh

# Fail fast
set -e

echo "Aguardando o banco de dados iniciar..."

# Aguarda o MySQL ficar disponível
until mysqladmin ping -h"$DB_HOST" --silent; do
  sleep 2
done

echo "Banco de dados iniciado!"

# Instala dependências (caso container seja recriado sem cache)
echo "Instalando dependências do Composer..."
composer install --no-interaction --optimize-autoloader

# Roda as migrations ao iniciar o projeto
echo "Rodando as migrations"
composer migrate
echo "Migrations carregadas com sucesso."

# Popula o banco com as seeders
echo "Carregando dados..."
composer seed
echo "Dados carregados com sucesso."

exec apache2-foreground

