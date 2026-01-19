#!/bin/bash

echo "🚀 Configurando CircuitoVida para Docker..."

# Verificar se o arquivo .env existe
if [ ! -f .env ]; then
    echo "📝 Criando arquivo .env..."
    cat > .env << 'EOF'
APP_NAME="Circuito Vida"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=circuitovida
DB_USERNAME=circuitovida_user
DB_PASSWORD=circuitovida_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Docker Configuration
APP_PORT=80
VITE_PORT=5173
FORWARD_DB_PORT=3306
DB_PORT_ADMIM=8080
WWWUSER=1000
WWWGROUP=1000
EOF
    echo "✅ Arquivo .env criado com sucesso!"
else
    echo "ℹ️  Arquivo .env já existe"
fi

# Verificar se as variáveis WWWUSER e WWWGROUP estão definidas
if ! grep -q "WWWUSER=" .env; then
    echo "🔧 Adicionando WWWUSER e WWWGROUP ao .env..."
    echo "WWWUSER=1000" >> .env
    echo "WWWGROUP=1000" >> .env
fi

# Instalar dependências do Composer
echo "📦 Instalando dependências do Composer..."
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

# Construir e iniciar os containers
echo "🐳 Construindo e iniciando containers..."
docker-compose up -d --build

# Aguardar o banco de dados estar pronto
echo "⏳ Aguardando banco de dados..."
sleep 10

# Configurar Laravel
echo "⚙️  Configurando Laravel..."
docker-compose exec atosdecristo php artisan key:generate
docker-compose exec atosdecristo php artisan migrate
docker-compose exec atosdecristo php artisan db:seed

# Configurar permissões
echo "🔐 Configurando permissões..."
docker-compose exec atosdecristo chmod -R 775 storage bootstrap/cache

# Compilar assets
echo "🎨 Compilando assets..."
docker-compose exec atosdecristo npm install
docker-compose exec atosdecristo npm run build

echo "🎉 Instalação concluída!"
echo "📱 Acesse: http://localhost"
echo "🗄️  PHPMyAdmin: http://localhost:8080" 