#!/bin/bash
set -e

# 1. Install necessary VM tools (for Jules to interact with the environment)
echo "Updating VM packages..."
sudo apt-get update && sudo apt-get install -y php-cli php-zip unzip docker-compose-plugin

# 2. Start the Docker containers
# This uses the docker-compose.yml we created earlier
echo "Building and starting containers..."
docker compose up -d --build

# 3. Health Check Loop for the 'app' service
echo "Waiting for 'app' container to be ready..."
MAX_RETRIES=30
COUNT=0

while [ "$(docker inspect -f '{{.State.Running}}' app 2>/dev/null)" != "true" ]; do
    if [ $COUNT -ge $MAX_RETRIES ]; then
        echo "Error: 'app' container failed to start within 60 seconds."
        exit 1
    fi
    
    echo "Waiting for app service... ($COUNT/$MAX_RETRIES)"
    sleep 2
    ((COUNT++))
done

echo "Container 'app' is running!"

# 4. Install PHP dependencies inside the 'app' container
echo "Running composer install inside the container..."
docker compose exec -T app composer install

echo "Setup complete!"
