#!/bin/bash

set -e

echo "Check mysql connection..."
# Wait for the database to be ready
while ! nc -z $DB_HOST $DB_PORT; do
    sleep 1
done


echo "Connection is established..."
# Check if the database exists
if ! mysql -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -e "use $DB_NAME"; then
    # Create the database
    echo "Create database..."
    mysql -h $DB_HOST -u $DB_USER -p$DB_PASSWORD -e "CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    echo "Database is created"
fi
