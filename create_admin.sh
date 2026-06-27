#!/bin/bash
# Script to create/reset the admin123 account in the Docker container
echo "Creating/Resetting admin123 account in active Docker container..."
docker exec -it cris-store-app php artisan db:seed --class=AdminUserSeeder
echo "Done!"
