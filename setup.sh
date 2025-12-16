#!/bin/bash
set -e

# 1. Install PHP and Composer in the VM (Jules needs this to run local commands)
sudo apt-get update
sudo apt-get install -y php-cli php-zip unzip

# Install Composer globally in the VM
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# 2. Start your Docker environment
# Jules VMs typically have Docker pre-installed, but you need to build/start your containers
docker-compose up -d --build

# 3. Install dependencies inside the container
# This ensures your PHP environment inside the Docker container is ready
docker-compose exec -T your-service-name composer install

# 4. (Optional) Run a quick validation
php -v
composer --version