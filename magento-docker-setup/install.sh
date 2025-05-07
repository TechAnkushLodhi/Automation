#!/bin/bash

# Load ENV vars
source .env

# Clone Magento
echo "📥 Cloning Magento..."
git clone https://github.com/magento/magento2.git html
cd html

# Start Docker
echo "🐳 Starting Docker containers..."
cd ..
docker-compose up -d

# Wait for DB to be ready
echo "⏳ Waiting for MySQL..."
sleep 20

# Run Composer
echo "📦 Installing composer dependencies..."
docker exec -it magento-web composer install

# Install Magento
echo "⚙️ Installing Magento..."
docker exec -it magento-web php bin/magento setup:install \
  --base-url=http://localhost:${MAGENTO_PORT} \
  --db-host=db \
  --db-name=${DB_NAME} \
  --db-user=${DB_USER} \
  --db-password=${DB_PASS} \
  --admin-firstname=Admin \
  --admin-lastname=User \
  --admin-email=admin@example.com \
  --admin-user=admin \
  --admin-password=admin123 \
  --backend-frontname=admin \
  --language=en_US \
  --currency=USD \
  --timezone=UTC \
  --use-rewrites=1

# Done!
echo "🎉 Magento Installed!"
echo "👉 Open in browser: http://localhost:${MAGENTO_PORT}"
