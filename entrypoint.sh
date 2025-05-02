#!/bin/bash

service apache2 start
service ssh start
service mariadb start

# Esperar a que Mariadb se inicie
sleep 10

# Crear nuevo usuario para que no haya conflictos
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "
    CREATE USER IF NOT EXISTS 'newuser'@'localhost' IDENTIFIED BY 'password';
    GRANT ALL PRIVILEGES ON *.* TO 'newuser'@'localhost' WITH GRANT OPTION;
    FLUSH PRIVILEGES;
"

# Crear base de datos soberbia
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE;"

# Pasar datos a mysql
mysql -u root -p$MYSQL_ROOT_PASSWORD $MYSQL_DATABASE < /docker-entrypoint-initdb.d/soberbia.sql

tail -f /dev/null